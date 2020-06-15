CREATE TABLE Orders(
	orderID int NOT NULL AUTO_INCREMENT,
	orderUserID int NOT NULL,
	orderDetailID int NOT NULL,
	status VARCHAR(50),
	orderDate DATE NOT NULL,
	shippedDate DATE,
	payment VARCHAR(64) NOT NULL,

	PRIMARY KEY (cartID),
	CONSTRAINT FK_orderUserID FOREIGN KEY (orderUserID) REFERENCES Users(userID)
);

CREATE TABLE Products(
	productID int NOT NULL AUTO_INCREMENT,
	name VARCHAR(128),
	brand VARCHAR(128),
	category VARCHAR(128),
	price int NOT NULL,
	stock int,

	PRIMARY KEY (productID)
);