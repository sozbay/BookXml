PGDMP     &    :            
    z            transfermate    15.1    15.1     
           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16398    transfermate    DATABASE     n   CREATE DATABASE transfermate WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'C';
    DROP DATABASE transfermate;
                postgres    false            �            1259    16399    authors    TABLE     c   CREATE TABLE public.authors (
    id integer NOT NULL,
    author character varying DEFAULT 255
);
    DROP TABLE public.authors;
       public         heap    postgres    false            �            1259    16418    authors_id_seq    SEQUENCE     �   ALTER TABLE public.authors ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.authors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    214            �            1259    16404    books    TABLE     w   CREATE TABLE public.books (
    id integer NOT NULL,
    book character varying(255),
    author_id bigint NOT NULL
);
    DROP TABLE public.books;
       public         heap    postgres    false            �            1259    16419    books_id_seq    SEQUENCE     �   ALTER TABLE public.books ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.books_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public          postgres    false    215                      0    16399    authors 
   TABLE DATA           -   COPY public.authors (id, author) FROM stdin;
    public          postgres    false    214   [
                 0    16404    books 
   TABLE DATA           4   COPY public.books (id, book, author_id) FROM stdin;
    public          postgres    false    215   x
                  0    0    authors_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.authors_id_seq', 1, false);
          public          postgres    false    216                       0    0    books_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.books_id_seq', 1, false);
          public          postgres    false    217            v
           2606    16403    authors authors_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.authors
    ADD CONSTRAINT authors_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.authors DROP CONSTRAINT authors_pkey;
       public            postgres    false    214            x
           2606    16408    books books_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.books
    ADD CONSTRAINT books_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.books DROP CONSTRAINT books_pkey;
       public            postgres    false    215               
   x������ � �         
   x������ � �     