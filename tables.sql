CREATE TABLE tblPaymentAccountDetails (
    padId int primary key AUTO_INCREMENT,
    padPartnerName varchar(128) not null,
    padLinkedEmail varchar(256) not null,
    padLinkedContactNumer char(10) not null,
    padLinkedBankAccountNumber varchar('32') not null,
    padLinkedBankName varchar('128') not null,
    padLinkedBankBalance decimal(14,2) not null,
    padPartnerKeyId varchar(128) not null,
    padPartnerSecret varchar(128) not null,
    padCredentialsExpiry datetime not null,
    padCredentialsCreatedDate datetime not null,
    padUpdatedDate datetime DEFAULT null ON UPDATE CURRENT_TIMESTAMP,
    padPartnerCreatedDate datetime CURRENT_TIMESTAMP,
    padPartnerStatus char(1) DEFAULT '1'
);
