
CREATE DATABASE IF NOT EXISTS library;
USE library;

CREATE TABLE IF NOT EXISTS User (
                        login varchar(50) NOT NULL UNIQUE,
                        user_id INT NOT NULL AUTO_INCREMENT UNIQUE,
                        passwordhash varchar(50) NOT NULL,
                        isActive BOOLEAN NOT NULL DEFAULT true,
                       	permission INT NOT NULL DEFAULT 1,
                        PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS Book (
                        book_id INT NOT NULL AUTO_INCREMENT,
                        title varchar(50) NOT NULL,
                        author_id INT NOT NULL,
                        category_id INT NOT NULL,
                        ISBN INT NOT NULL,
                        available BOOLEAN NOT NULL DEFAULT '1',
                        lowtitle varchar(50) NOT NULL DEFAULT lower(title),
                        PRIMARY KEY (book_id)
);

CREATE INDEX IF NOT EXISTS book_lower_title_idx
	ON Book (lowtitle);

CREATE INDEX IF NOT EXISTS ISBN_idx
	ON Book (ISBN);
	
	
CREATE TABLE IF NOT EXISTS Rent (
                        rent_id INT NOT NULL AUTO_INCREMENT,
                        book_id INT NOT NULL,
                        user_id INT NOT NULL,
                        start DATE NOT NULL,
                        end DATE,
                        PRIMARY KEY (rent_id),
                        constraint proper_date
        			check ((end IS NULL) OR (end >= start))
                        
);

CREATE TABLE IF NOT EXISTS Author (
                          author_id INT NOT NULL AUTO_INCREMENT,
                          name varchar(50) NOT NULL,
                          surname varchar(50) NOT NULL,
                          lowname varchar(50) NOT NULL DEFAULT lower(name),
                          lowsurname varchar(50)  NOT NULL DEFAULT lower(surname),
                          PRIMARY KEY (author_id)
);

CREATE INDEX IF NOT EXISTS author_lower_name_idx
	ON Author (lowname);
	
CREATE INDEX IF NOT EXISTS author_lower_surname_idx
	ON Author (lowsurname);
	
	
CREATE TABLE IF NOT EXISTS Category (
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
