-- ============================================================
-- Hospital Management System - Database Schema
-- ============================================================

CREATE DATABASE IF NOT EXISTS hospital_db;
USE hospital_db;

-- ---------------------------------------------
-- Table: users  (system login for staff/admin)
-- ---------------------------------------------
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------
-- Table: doctors
-- ---------------------------------------------
CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    availability VARCHAR(100) DEFAULT 'Mon-Fri, 9AM-5PM',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------
-- Table: patients
-- ---------------------------------------------
CREATE TABLE patients (
    patient_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    gender ENUM('Male','Female','Other') NOT NULL,
    dob DATE,
    phone VARCHAR(20),
    email VARCHAR(100),
    address VARCHAR(255),
    blood_group VARCHAR(5),
    registered_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ---------------------------------------------
-- Table: appointments
-- ---------------------------------------------
CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    reason VARCHAR(255),
    status ENUM('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(doctor_id) ON DELETE CASCADE
);

-- ---------------------------------------------
-- Table: inventory  (medicines / hospital supplies)
-- ---------------------------------------------
CREATE TABLE inventory (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    quantity INT NOT NULL DEFAULT 0,
    unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    supplier VARCHAR(100),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ---------------------------------------------
-- Table: billing
-- ---------------------------------------------
CREATE TABLE billing (
    bill_id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    appointment_id INT,
    consultation_fee DECIMAL(10,2) DEFAULT 0.00,
    medicine_charges DECIMAL(10,2) DEFAULT 0.00,
    other_charges DECIMAL(10,2) DEFAULT 0.00,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Paid','Unpaid','Partial') DEFAULT 'Unpaid',
    billing_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(patient_id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(appointment_id) ON DELETE SET NULL
);

-- ============================================================
-- Sample Data
-- ============================================================

-- Default admin login -> username: admin | password: admin123
INSERT INTO users (full_name, username, password, role) VALUES
('System Administrator', 'admin', '$2y$10$YzXk3Dq0iN1JZ5Rb0m5B0eF8x1p4wQyQOq6f6CqU1t1kU8pQmS5Nu', 'admin');

INSERT INTO doctors (full_name, specialization, phone, email, availability) VALUES
('Dr. Aditya Sharma', 'Cardiologist', '9876543210', 'aditya.sharma@hospital.com', 'Mon-Fri, 9AM-3PM'),
('Dr. Neha Verma', 'Pediatrician', '9876543211', 'neha.verma@hospital.com', 'Mon-Sat, 10AM-4PM'),
('Dr. Rohan Mehta', 'Orthopedic', '9876543212', 'rohan.mehta@hospital.com', 'Tue-Sat, 11AM-6PM');

INSERT INTO patients (full_name, gender, dob, phone, email, address, blood_group) VALUES
('Ravi Kumar', 'Male', '1990-05-14', '9998887771', 'ravi.kumar@mail.com', 'Sector 21, Gurugram', 'B+'),
('Anita Singh', 'Female', '1985-11-02', '9998887772', 'anita.singh@mail.com', 'Model Town, Delhi', 'O+'),
('Karan Patel', 'Male', '2001-02-19', '9998887773', 'karan.patel@mail.com', 'Satellite, Ahmedabad', 'A-');

INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, reason, status) VALUES
(1, 1, CURDATE(), '10:30:00', 'Routine heart checkup', 'Scheduled'),
(2, 2, CURDATE(), '11:00:00', 'Child vaccination', 'Scheduled'),
(3, 3, DATE_SUB(CURDATE(), INTERVAL 2 DAY), '15:00:00', 'Knee pain follow-up', 'Completed');

INSERT INTO inventory (item_name, category, quantity, unit_price, supplier) VALUES
('Paracetamol 500mg', 'Medicine', 500, 1.50, 'MedSupply Co.'),
('Surgical Gloves (box)', 'Consumable', 120, 8.00, 'SafeHands Ltd.'),
('Digital Thermometer', 'Equipment', 40, 15.00, 'MediTech Devices'),
('Bandage Rolls', 'Consumable', 300, 2.25, 'SafeHands Ltd.');

INSERT INTO billing (patient_id, appointment_id, consultation_fee, medicine_charges, other_charges, total_amount, payment_status) VALUES
(3, 3, 500.00, 150.00, 0.00, 650.00, 'Paid');
