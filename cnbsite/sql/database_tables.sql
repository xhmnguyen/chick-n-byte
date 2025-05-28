CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) DEFAULT NULL, -- Optional phone number
    address TEXT DEFAULT NULL, -- Optional address
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE menu_items (
    menu_item_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    calories INT,
    ingredients TEXT,
    image_url VARCHAR(255)
);

CREATE TABLE cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    session_id VARCHAR(255) NOT NULL,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(menu_item_id) ON DELETE CASCADE
);


CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL, -- NULL for guest users
    customer_name VARCHAR(255) DEFAULT NULL, -- For guest users
    customer_email VARCHAR(255) DEFAULT NULL, -- For guest users
    total_price DECIMAL(10, 2) NOT NULL,
    order_type ENUM('pickup', 'delivery') NOT NULL,
    delivery_address TEXT DEFAULT NULL,
    order_notes TEXT DEFAULT NULL,
    status ENUM('pending', 'preparing', 'ready', 'out_for_delivery', 'completed') DEFAULT 'pending',
    assigned_driver_id INT DEFAULT NULL, -- Driver assigned to the order
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_driver_id) REFERENCES staff(id) ON DELETE SET NULL 
);


CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(menu_item_id)
);

CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('delivery_driver', 'kitchen_staff', 'manager') NOT NULL
);