create table user_book (
    user_id int not null,
    book_id int not null,
    primary key (user_id, book_id),
    foreign key (user_id) references user(user_id) on delete cascade,
    foreign key (book_id) references books(book_id) on delete cascade,
    borrow_date datetime default current_timestamp,
    return_date datetime,
    status enum('borrowed', 'returned') default 'borrowed'
);