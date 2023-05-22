
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
                            description varchar(500) NOT NULL,
                            PRIMARY KEY (category_id)
);

ALTER TABLE Book ADD CONSTRAINT Book_fk0 FOREIGN KEY (author_id) REFERENCES Author(author_id);

ALTER TABLE Book ADD CONSTRAINT Book_fk1 FOREIGN KEY (category_id) REFERENCES Category(category_id);

ALTER TABLE Rent ADD CONSTRAINT Rent_fk0 FOREIGN KEY (book_id) REFERENCES Book(book_id);

ALTER TABLE Rent ADD CONSTRAINT Rent_fk1 FOREIGN KEY (user_id) REFERENCES User(user_id);


INSERT INTO Library.User (login, passwordhash, isActive, permission) VALUES ('a@gmail.com', '123', DEFAULT, DEFAULT);


ALTER TABLE Library.Category AUTO_INCREMENT = 1;
INSERT INTO Library.Category (name, description) VALUES ('Classic Literature', 'Works of enduring literary significance.');
INSERT INTO Library.Category (name, description) VALUES ('Coming-of-Age Novels', 'Novels that focus on the psychological and moral growth of a protagonist from youth to adulthood.');
INSERT INTO Library.Category (name, description) VALUES ('Dystopian Fiction', 'Novels set in a futuristic society characterized by oppressive social control and a dehumanized existence.');
INSERT INTO Library.Category (name, description) VALUES ('Romance', 'Novels that explore the romantic relationships between characters.');
INSERT INTO Library.Category (name, description) VALUES ('Bildungsroman', 'Novels that depict the personal growth and development of the protagonist, often from childhood to maturity.');
INSERT INTO Library.Category (name, description) VALUES ('Fantasy Adventure', 'Novels that combine elements of fantasy and adventure, often featuring quests, magical creatures, and heroic characters.');
INSERT INTO Library.Category (name, description) VALUES ('Epic Fantasy', 'Vast, intricate fantasy narratives set in imaginary worlds, often involving epic battles between good and evil.');
INSERT INTO Library.Category (name, description) VALUES ('Children''s Fantasy', 'Fantasy novels specifically targeted towards young readers.');
INSERT INTO Library.Category (name, description) VALUES ('Adventure', 'Novels that revolve around exciting adventures and journeys.');
INSERT INTO Library.Category (name, description) VALUES ('Thriller/Mystery', 'Suspenseful novels that involve thrilling plots and often revolve around solving a mystery or crime.');
INSERT INTO Library.Category (name, description) VALUES ('Young Adult Dystopian Fiction', 'Dystopian novels targeted towards young adult readers, exploring themes of rebellion, survival, and identity.');
INSERT INTO Library.Category (name, description) VALUES ('Allegorical Fiction', 'Fictional works that use symbolism and metaphor to convey deeper moral, political, or social meanings.');
INSERT INTO Library.Category (name, description) VALUES ('Fantasy', 'Imaginative fiction that features magical or supernatural elements, often set in a secondary world.');
INSERT INTO Library.Category (name, description) VALUES ('Historical Fiction', 'Novels set in the past, often blending fictional characters and events with historical context.');
INSERT INTO Library.Category (name, description) VALUES ('Psychological Thriller', 'Suspenseful novels that emphasize the psychological and emotional states of the characters, often involving mind games and twists.');
INSERT INTO Library.Category (name, description) VALUES ('Crime Fiction', 'Novels that revolve around crime, criminals, and the investigation of criminal acts.');
INSERT INTO Library.Category (name, description) VALUES ('Science Fiction', 'Novels that explore imaginative and futuristic concepts, often incorporating scientific and technological advancements.');
INSERT INTO Library.Category (name, description) VALUES ('Mythology', 'Books that delve into the traditional stories, legends, and myths of a particular culture or civilization.');
INSERT INTO Library.Category (name, description) VALUES ('History', 'Books that provide factual accounts and analysis of past events and civilizations.');
INSERT INTO Library.Category (name, description) VALUES ('Military Strategy', 'Books that focus on military tactics, strategy, and the art of warfare.');


ALTER TABLE Library.Author AUTO_INCREMENT = 1;
INSERT INTO Library.Author (name, surname) VALUES ('F. Scott', 'Fitzgerald');
INSERT INTO Library.Author (name, surname) VALUES ('Harper', 'Lee');
INSERT INTO Library.Author (name, surname) VALUES ('George', 'Orwell');
INSERT INTO Library.Author (name, surname) VALUES ('Jane', 'Austen');
INSERT INTO Library.Author (name, surname) VALUES ('J.D.', 'Salinger');
INSERT INTO Library.Author (name, surname) VALUES ('J.K.', 'Rowling');
INSERT INTO Library.Author (name, surname) VALUES ('J.R.R.', 'Tolkien');
INSERT INTO Library.Author (name, surname) VALUES ('Herman', 'Melville');
INSERT INTO Library.Author (name, surname) VALUES ('Dan', 'Brown');
INSERT INTO Library.Author (name, surname) VALUES ('Suzanne', 'Collins');
INSERT INTO Library.Author (name, surname) VALUES ('Paulo', 'Coelho');
INSERT INTO Library.Author (name, surname) VALUES ('C.S.', 'Lewis');
INSERT INTO Library.Author (name, surname) VALUES ('Khaled', 'Hosseini');
INSERT INTO Library.Author (name, surname) VALUES ('Gillian', 'Flynn');
INSERT INTO Library.Author (name, surname) VALUES ('Stieg', 'Larsson');
INSERT INTO Library.Author (name, surname) VALUES ('Aldous', 'Huxley');
INSERT INTO Library.Author (name, surname) VALUES ('Homer', '');
INSERT INTO Library.Author (name, surname) VALUES ('Yuval Noah', 'Harari');
INSERT INTO Library.Author (name, surname) VALUES ('Sun', 'Tzu');
INSERT INTO Library.Author (name, surname) VALUES ('Lee', 'Harper');

ALTER TABLE Library.Book AUTO_INCREMENT = 1;
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Great Gatsby', 1 , 1, '0333791037');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('To Kill a Mockingbird', 2 , 2, '0827495136');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('1984', 3 , 3, '0065398172');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('Pride and Prejudice', 4 , 4, '0972563841');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Catcher in the Rye', 5 , 5, '0139467528');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('Harry Potter and the Sorcerer''s Stone', 6 , 6, '0048612397');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Lord of the Rings', 7 , 7, '0674185293');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Hobbit', 7 , 8, '0492158736');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('Moby-Dick', 8 , 9, '0025379164');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Da Vinci Code', 9 , 10, '0847239156');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Hunger Games', 10 , 11, '0056178924');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Alchemist', 11 , 12, '0238167594');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Chronicles of Narnia', 12 , 13, '0931482765');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Kite Runner', 13 , 14, '0019358274');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('Gone Girl', 14 , 15, '0709851234');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Girl with the Dragon Tattoo', 15 , 16, '0268473951');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('Brave New World', 16 , 17, '0983145276');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Odyssey', 17 , 18, '0419267385');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('Sapiens: A Brief History of Humankind', 18 , 19, '0362158497');
INSERT INTO Library.Book(title, author_id, category_id, ISBN) VALUES ('The Art of War', 19 , 20, '0127394865');
commit;
