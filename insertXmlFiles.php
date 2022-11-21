<?php

class TreeView
{

    public function getTree($path)
    {
        include "database.php";

        $folders = [];
        $files = [];

        foreach (scandir($path) as $node) {
            if ($this->filter($node)) {
                continue;
            }

            if (is_dir($path . '/' . $node)) {
                $folders[$node] = self::getTree($path . '/' . $node);
            } else {
                $filesInfos = pathinfo($node);
                if ($filesInfos['extension'] === "xml") {

                    $xml = (array)simplexml_load_file("$path" . '/' . "$node");
                    foreach ($xml['Book'] as $book) {

                        $authorSql = $pdo->query("SELECT *
                                    FROM authors
                                 where authors.author='" . $book->Author . "'");

                        $authorResult = $authorSql->fetch(PDO::FETCH_ASSOC);

                        if ($authorResult) {
                            $bookSql = $pdo->prepare("SELECT books.id
                                            , books.book
                                            , authors.author
                                            FROM authors LEFT JOIN books ON books.author_id = authors.id
                                 where books.author_id=:id and books.book=:book");
                            $bookSql->execute(['id' => $authorResult['id'], 'book' => $book->BookName]);
                            $bookResult = $bookSql->fetchAll(PDO::FETCH_ASSOC);
                            if (!$bookResult) {
                                $bookQuery = $pdo->prepare("INSERT INTO books(book,author_id) VALUES(?,?)");
                                $bookQuery->bindParam(1, $book->BookName, PDO::PARAM_STR);
                                $bookQuery->bindParam(2, $authorResult['id'], PDO::PARAM_INT);
                                $bookQuery->execute();
                            }
                        } else {

                            $authorQuery = $pdo->prepare("INSERT INTO authors(author) VALUES(?)");
                            $authorQuery->bindParam(1, $book->Author, PDO::PARAM_STR);
                            $authorQuery->execute();

                            $bookQuery = $pdo->prepare("INSERT INTO books(book,author_id) VALUES(?,?)");
                            $bookQuery->bindParam(1, $book->BookName, PDO::PARAM_STR);
                            @$bookQuery->bindParam(2, $pdo->lastInsertId(), PDO::PARAM_INT);
                            $bookQuery->execute();
                        }
                    }
                }
                $files[] = $node;
            }
        }

        return array_merge($folders, $files);
    }

    private function filter($filename)
    {
        return in_array($filename, ['.', '..', 'index.php', '.htaccess', '.xml']);
    }
}

$treeView = new TreeView();
$tree = $treeView->getTree('authors');
