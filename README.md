# Internet-Book-Store
Database II, Internet Book Store

Phase 1: Database design

In this project, you will design a web-based database for an Internet bookstore. In the database, there should be information about books, authors, customers, purchase history, etc.

You should design a conceptual model of the database and draw an ER diagram that captures the information. Your task is to model the data stored in the database: (1) identify the entity sets and relationship sets; (2) show attributes; and (3) indicate constraints for each entity/relationship set. Make sure that your ER model captures the requirements described in class.

After you have designed the ER diagram, you should translate it into relational schema.


Phase 2: Building a relational database management system

This is the major part of the project.

First, you should create a database called "bookdb" containing the tables designed in Phase 1 in MySQL and populate the database. 
Your database should contain the following baseline tables. You may add extra attributes and/or create additional tables according to your E-R diagram design.
people (name, address, telephone, email)
author (aid, name, address) foreign key (name, address) references people (name, address)
customer (cid, name, address) foreign key (name, address) references people (name, address) 
publiser (pname, city, state) 
book (ISBN13, title, year, category, pname, price) foreign key (pname) references publisher (pname) 
writes (ISBN13, aid) foreign key (ISBN13) references book (ISBN13) foreign key (aid) references author (aid) 
purchase (ISBN13, cid, datetime) foreign key (ISBN13) references book (ISBN13) foreign key (cid) references customer (cid)

You may extract book data from amazon and fabricated customer data and insert them into your database. Each table should contain at least 10 tuples. You can do this step either using "phpMyAdmin" in XAMPP or at MySQL command line.

After you have created and polulated the database, you should use "mysqldump --databases bookdb --user=root --password > bookdb_dump.sql" to create a dump file of your database.

Next, you should implement an html file as the user interface that will take user input and a PHP file that will use the user input to query and modify the MySQL database you have created.

Below is the list of baseline queries you should implement in PHP. You may implement additional queries based on the database you have created.

Find the names of authors who have purchased a book written by themselves. (aid and cid will not be the same).
User input one author name, find all the books written by the author(s).
User input one customer name, find purchase history of the customer(s).
User input one or more words of a book title, find all information of the books whose titles contain those words.
Design a drop down menu so user can use it to select a year and find the title of the best selling book of that year.
Record the information that a customr has purchased a book.
Add a new customer to the database.
User input one name and address, update the address in people, and author or customer table if applicable.
Add a new book to the database. If the author and/or the publisher of the new book is not in the database, insert all information about the author and/or publisher as well.
Delete a book. If the author of the book has not written other books, delete the author as well.
NOTE: Do not use Java Script or CSS in your html file. 

Phase 3: Developing an Android application

Develop a database application with GUI in Android platform that can connect to the DBMS (MySQL). The application should request all information required for connection from a user, such as login, password, connection URL, etc., and should take any user query, execute it, and return its result to the user.

The application should also have a clear purpose and a user-friendly interface. Users do not need to know the details of the database or the SQL language to manipulate the data. A graphical interface is desired.

You are required to display query results using View objects in android.

Implement at least three queries selected from Phase 2, such that the user can execute them via Android app.

