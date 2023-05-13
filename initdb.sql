
CREATE DATABASE library;
USE library;

CREATE TABLE User (
                        login varchar(50) NOT NULL UNIQUE,
                        user_id INT NOT NULL AUTO_INCREMENT UNIQUE,
                        password varchar(50) NOT NULL,
                        isActive BOOLEAN NOT NULL DEFAULT true,
                        PRIMARY KEY (user_id)
);

CREATE TABLE Book (
                        book_id INT NOT NULL AUTO_INCREMENT,
                        title varchar(50) NOT NULL,
                        author_id INT NOT NULL,
                        category_id INT NOT NULL,
                        available BOOLEAN NOT NULL DEFAULT '1',
                        PRIMARY KEY (book_id)
);

CREATE TABLE Rent (
                        rent_id INT NOT NULL AUTO_INCREMENT,
                        book_id INT NOT NULL,
                        user_id INT NOT NULL,
                        start DATE NOT NULL,
                        end DATE,
                        PRIMARY KEY (rent_id)
);

CREATE TABLE Author (
                          author_id INT NOT NULL AUTO_INCREMENT,
                          name varchar(50) NOT NULL,
                          surname varchar(50) NOT NULL,
                          PRIMARY KEY (author_id)
);

CREATE TABLE Category (
                            category_id INT NOT NULL AUTO_INCREMENT,
                            name varchar(50) NOT NULL UNIQUE,
                            description varchar(50) NOT NULL,
                            PRIMARY KEY (category_id)
);

ALTER TABLE Book ADD CONSTRAINT Book_fk0 FOREIGN KEY (author_id) REFERENCES Author(author_id);

ALTER TABLE Book ADD CONSTRAINT Book_fk1 FOREIGN KEY (category_id) REFERENCES Category(category_id);

ALTER TABLE Rent ADD CONSTRAINT Rent_fk0 FOREIGN KEY (book_id) REFERENCES Book(book_id);

ALTER TABLE Rent ADD CONSTRAINT Rent_fk1 FOREIGN KEY (user_id) REFERENCES User(user_id);

commit;
