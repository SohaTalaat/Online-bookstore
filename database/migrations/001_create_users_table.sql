create table user (
    user_id int auto_increment primary key,
    name varchar(100) not null,
    email varchar(100) not null unique,
    password varchar(255) not null,
    role enum('admin', 'student') default 'student',
    phone varchar(50),
    address varchar(255)
);