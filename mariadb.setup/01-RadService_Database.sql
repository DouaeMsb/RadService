CREATE TABLE bike_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    base_price DECIMAL(6,2) NOT NULL
);

CREATE TABLE repair_order (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bike_type_id INT NOT NULL,
    problem_description TEXT NOT NULL,
    priority ENUM('niedrig','mittel','hoch') DEFAULT 'mittel',
    address VARCHAR(255) NOT NULL,
    status TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bike_type_id) REFERENCES bike_type(id)
);
