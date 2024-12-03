Create database vitaflow;

use vitaflow;

Create table BloodGroup(BloodGroupId INT AUTO_INCREMENT PRIMARY KEY,
BloodType varchar(10));

Create table Donor(DonorId INT AUTO_INCREMENT PRIMARY KEY,
DonorName varchar(20),
BloodGroupId int,
Age int,
Email varchar(30),
Phone int,
Password varchar(250) DEFAULT NULL,
Foreign key (BloodGroupId) references BloodGroup(BloodGroupId));

Create table Receiver(ReceiverId INT AUTO_INCREMENT PRIMARY KEY,
ReceiverName varchar(10),
BloodGroupId int,
DonorId int,
Age int,
Email varchar(30),
Phone int,
Password varchar(250) DEFAULT NULL,
Foreign key (BloodGroupId) references BloodGroup(BloodGroupId),
Foreign key (DonorId) references Donor(DonorId));

Create table Admin(AdminId INT AUTO_INCREMENT PRIMARY KEY,
AdminName varchar(30),
DonorId int,
ReceiverId int,
BloodGroupId int,
Password varchar(250) DEFAULT NULL,
Foreign key (BloodGroupId) references BloodGroup(BloodGroupId),
Foreign key (DonorId) references Donor(DonorId),
Foreign key (ReceiverId) references Receiver(ReceiverId));