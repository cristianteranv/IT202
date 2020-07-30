/*Cart table*/

CREATE TABLE Users(
	id int auto_increment not null,
	email varchar(100) not null unique,
	first_name varchar(100),
	last_name varchar(100),
	password varchar(60),
	created timestamp default current_timestamp,
	modified timestamp default current_timestamp on update current_timestamp,
	PRIMARY KEY (id)
)

CREATE TABLE Orders(
	id int NOT NULL AUTO_INCREMENT,
	orderUserId int NOT NULL,
	orderDetailId int NOT NULL,
	status VARCHAR(50),
	orderDate DATE NOT NULL,
	shippedDate DATE,
	payment VARCHAR(64) NOT NULL,

	PRIMARY KEY (cartId),
	CONSTRAINT FK_orderUserId FOREIGN KEY (orderUserId) REFERENCES Users(id)
);

CREATE TABLE Products(
	id int AUTO_INCREMENT,
	/*userID: User who added and edits the product*/
	name VARCHAR(64) NOT NULL UNIQUE,
	brand VARCHAR(64) NOT NULL,
	category VARCHAR(128),
	price decimal(10,2) default 0.00,
	/*discount decimal(3,2) default 1.00*/
	stock int default 0,
	description TEXT,
	modified datetime default current_timestamp on update current_timestamp,
	created datetime default current_timestamp,

	PRIMARY KEY (id)
)
	/*CHARACTER SET utf8 COLLATE utf8_general_ci*/


CREATE TABLE Carts(
	id int AUTO_INCREMENT,
	userId int,
	productId int,
	quantity int,
	price decimal(10,2),
	created timestamp default current_timestamp,

	PRIMARY KEY (id),
	CONSTRAINT FK_cartUserId FOREIGN KEY (userId) REFERENCES Users(id),
	CONSTRAINT FK_productId FOREIGN KEY (productId) REFERENCES Products(id)
)