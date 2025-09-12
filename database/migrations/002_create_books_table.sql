create table books (
    book_id int auto_increment primary key,
    title varchar(255) not null,
    author varchar(100) not null,
    description text,
    cover_url varchar(512) null,
    total_copies int not null,
    available_copies int not null
);