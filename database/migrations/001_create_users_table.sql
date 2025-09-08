create table user (
    user_id int auto_increment primary key,
    name varchar(100) not null,
    email varchar(100) not null unique,
    password varchar(255) not null,
    student_id varchar(50) unique,
    role enum('admin', 'student') default 'student',
    phone varchar(50),
    address varchar(255)
);