CREATE TABLE loan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  loan_amount DECIMAL(10, 2) NOT NULL,
  purpose ENUM('Personal', 'Business', 'Education', 'Other') NOT NULL
);