# **VitaFlow: Online Blood Donation Management System**

## **Description**
VitaFlow is a web-based platform designed to connect blood donors, receivers, and administrators, ensuring efficient management of blood donations. The system provides secure role-based access for seamless operations, including donor registration, blood stock monitoring, and appointment scheduling.

## **Features**
- **Donor Management**: 
  - Register, update profiles, and view donation history.
- **Receiver Management**: 
  - Request blood and track request status.
- **Blood Group Management**: 
  - Maintain and monitor blood group stocks and requests.
- **Admin Dashboard**: 
  - Oversee users, blood stock, and blood requests.
- **Secure Authentication**: 
  - Role-based login for admins, donors, and receivers.

## **Tech Stack**
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (phpMyAdmin)
- **Development Tools**: XAMPP, Visual Studio Code

## **Database Structure**
| **Table**             | **Columns**                                                                                       |
|-----------------------|--------------------------------------------------------------------------------------------------|
| `Admin`               | `AdminId`, `AdminName`, `DonorId`, `ReceiverId`, `BloodGroupId`, `Password`                       |
| `Donor`               | `DonorId`, `DonorName`, `BloodGroupId`, `Age`, `Email`, `Phone`, `Password`                       |
| `Receiver`            | `ReceiverId`, `ReceiverName`, `BloodGroupId`, `DonorId`, `Age`, `Email`, `Phone`, `Password`      |
| `BloodGroup`          | `BloodGroupId`, `BloodType`                                                                      |
| `BloodGroupRequests`  | `RequestId`, `BloodGroupId`, `ReceiverId`, `RequestDate`, `Status`                                |

## **Setup Instructions**
### **Prerequisites**
- Install [XAMPP](https://www.apachefriends.org/index.html) for the local server environment.
- Install [Visual Studio Code](https://code.visualstudio.com/) or any preferred IDE.

### **Database Configuration**
1. Import the provided SQL file into **phpMyAdmin** to create the necessary tables.
2. Update database connection settings in the PHP files:
   ```php
   $host = 'localhost';
   $username = 'root';
   $password = '';
   $database = 'vitaflow';
