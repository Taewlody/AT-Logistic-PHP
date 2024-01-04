/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ats

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-07-20 17:05:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for common_charge
-- ----------------------------
DROP TABLE IF EXISTS `common_charge`;
CREATE TABLE `common_charge` (
  `comCode` varchar(30) NOT NULL,
  `chargeCode` varchar(30) NOT NULL,
  `chargeName` varchar(255) DEFAULT '',
  `typeCode` varchar(30) NOT NULL DEFAULT '',
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`chargeCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_charge
-- ----------------------------
INSERT INTO `common_charge` VALUES ('C01', 'C-001', 'ค่าตีลัง', 'V-01', '1', 'admin', '2021-07-19 20:11:17', 'admin', '2021-07-19 21:53:45');
INSERT INTO `common_charge` VALUES ('C01', 'C-002', 'ค่าลงทะเบียนกรมศุลกากร', 'V-02', '1', 'admin', '2021-07-19 20:11:33', 'admin', '2021-07-19 20:11:33');

-- ----------------------------
-- Table structure for common_chargestype
-- ----------------------------
DROP TABLE IF EXISTS `common_chargestype`;
CREATE TABLE `common_chargestype` (
  `comCode` varchar(30) NOT NULL,
  `typeCode` varchar(30) NOT NULL,
  `typeName` varchar(255) DEFAULT '',
  `vatType` varchar(30) NOT NULL DEFAULT '',
  `amount` double(15,2) DEFAULT 0.00,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`typeCode`) USING BTREE,
  KEY `FK_port_country` (`comCode`,`vatType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_chargestype
-- ----------------------------
INSERT INTO `common_chargestype` VALUES ('C01', 'V-01', 'ค่าขนส่ง', 'T-02', '1.00', '1', 'admin', '2021-07-19 12:39:37', 'admin', '2021-07-19 12:40:10');
INSERT INTO `common_chargestype` VALUES ('C01', 'V-02', 'ค่าบริการ', 'T-02', '3.00', '1', 'admin', '2021-07-19 12:40:33', 'admin', '2021-07-19 12:40:46');

-- ----------------------------
-- Table structure for common_containersize
-- ----------------------------
DROP TABLE IF EXISTS `common_containersize`;
CREATE TABLE `common_containersize` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `containersizeCode` varchar(30) NOT NULL,
  `containersizeName` varchar(255) DEFAULT NULL,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`containersizeCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_containersize
-- ----------------------------
INSERT INTO `common_containersize` VALUES ('C01', 'T-01', '20', '1', 'admin', '2021-07-20 13:18:37', 'admin', '2021-07-20 13:18:37');
INSERT INTO `common_containersize` VALUES ('C01', 'T-02', '40', '1', 'admin', '2021-07-20 13:18:44', 'admin', '2021-07-20 13:18:44');
INSERT INTO `common_containersize` VALUES ('C01', 'T-03', '40 RH', '1', 'admin', '2021-07-20 13:18:51', 'admin', '2021-07-20 13:18:51');
INSERT INTO `common_containersize` VALUES ('C01', 'T-04', '40 HQ', '1', 'admin', '2021-07-20 13:18:57', 'admin', '2021-07-20 13:18:57');
INSERT INTO `common_containersize` VALUES ('C01', 'T-05', 'Flat Rack', '1', 'admin', '2021-07-20 13:19:03', 'admin', '2021-07-20 13:19:03');

-- ----------------------------
-- Table structure for common_containertype
-- ----------------------------
DROP TABLE IF EXISTS `common_containertype`;
CREATE TABLE `common_containertype` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `containertypeCode` varchar(30) NOT NULL,
  `containertypeName` varchar(255) DEFAULT NULL,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`containertypeCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_containertype
-- ----------------------------
INSERT INTO `common_containertype` VALUES ('C01', 'T-02', 'Dry', '1', 'admin', '2021-07-20 13:01:58', 'admin', '2021-07-20 13:01:58');
INSERT INTO `common_containertype` VALUES ('C01', 'T-03', 'Flatrack', '1', 'admin', '2021-07-20 13:02:04', 'admin', '2021-07-20 13:02:04');
INSERT INTO `common_containertype` VALUES ('C01', 'T-04', 'Hanger', '1', 'admin', '2021-07-20 13:02:11', 'admin', '2021-07-20 13:02:11');
INSERT INTO `common_containertype` VALUES ('C01', 'T-05', 'Open Top', '1', 'admin', '2021-07-20 13:02:20', 'admin', '2021-07-20 13:02:20');
INSERT INTO `common_containertype` VALUES ('C01', 'T-06', 'Reefer', '1', 'admin', '2021-07-20 13:02:26', 'admin', '2021-07-20 13:02:26');
INSERT INTO `common_containertype` VALUES ('C01', 'T-07', 'Reefer Dry', '1', 'admin', '2021-07-20 13:02:32', 'admin', '2021-07-20 13:02:32');
INSERT INTO `common_containertype` VALUES ('C01', 'T-08', 'Tank', '1', 'admin', '2021-07-20 13:02:39', 'admin', '2021-07-20 13:02:39');

-- ----------------------------
-- Table structure for common_contractperson
-- ----------------------------
DROP TABLE IF EXISTS `common_contractperson`;
CREATE TABLE `common_contractperson` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `contactCode` varchar(30) NOT NULL,
  `cusCode` varchar(30) NOT NULL DEFAULT '' COMMENT 'รหัสลุกค้า',
  `contactNameEN` varchar(120) DEFAULT NULL COMMENT 'ชื่อลูค้าภาษาอังกฤษ',
  `contactNameTH` varchar(120) DEFAULT NULL COMMENT 'ชื่อลูกค้าภาษาไทย',
  `taxID` varchar(13) DEFAULT NULL COMMENT 'เลขประจำตัวผู้เสียภาษี',
  `th_addressNo` varchar(100) DEFAULT '' COMMENT 'ที่อยู่เลขที่',
  `th_moo` varchar(100) DEFAULT '' COMMENT 'หมู่',
  `
th_village` varchar(255) DEFAULT '' COMMENT 'หมู่บ้าน',
  `th_soi` varchar(255) DEFAULT NULL COMMENT 'ซอย',
  `th_road` varchar(255) DEFAULT '' COMMENT 'ถนน',
  `th_subdistrict` varchar(255) DEFAULT '' COMMENT 'ตำบล',
  `th_district` varchar(255) DEFAULT '' COMMENT 'อำเภอ',
  `th_province` varchar(255) DEFAULT '' COMMENT 'จังหวัด',
  `zipCode` varchar(5) DEFAULT '' COMMENT 'รหัสไปรษณีย์',
  `th_addressbill` text DEFAULT NULL COMMENT 'ที่อยู่เปิดบิล',
  `en_addressNo` varchar(255) DEFAULT '' COMMENT 'เลขที่',
  `en_moo` varchar(255) DEFAULT '' COMMENT 'หมู่',
  `en_addressbill` varchar(255) DEFAULT '',
  `en_village` varchar(255) DEFAULT '',
  `en_soi` varchar(255) DEFAULT NULL,
  `en_road` varchar(255) DEFAULT '',
  `en_subdistrict` varchar(255) DEFAULT '',
  `en_district` varchar(255) DEFAULT '',
  `en_province` varchar(255) DEFAULT '',
  `countryCode` varchar(30) DEFAULT '',
  `tel` varchar(255) DEFAULT '' COMMENT 'โทรศัพท์',
  `fax` varchar(255) DEFAULT '' COMMENT 'แฟกซ์',
  `mobile` varchar(255) DEFAULT '' COMMENT 'มือถือ',
  `mail` varchar(100) DEFAULT NULL COMMENT 'เมล์',
  `lineID` varchar(100) DEFAULT NULL COMMENT 'ไอดีไลน์',
  `website` varchar(100) DEFAULT NULL COMMENT 'เว็บไซต์',
  `note` text DEFAULT NULL,
  `IsActive` char(1) DEFAULT '' COMMENT 'สถานะ',
  `createID` varchar(30) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`contactCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_contractperson
-- ----------------------------

-- ----------------------------
-- Table structure for common_country
-- ----------------------------
DROP TABLE IF EXISTS `common_country`;
CREATE TABLE `common_country` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `countryCode` varchar(30) NOT NULL,
  `countryNameTH` varchar(255) DEFAULT NULL,
  `countryNameEN` varchar(255) DEFAULT NULL,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`countryCode`),
  KEY `IN_CountryName` (`countryNameTH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_country
-- ----------------------------
INSERT INTO `common_country` VALUES ('C01', 'ABW', 'อารูบา', 'Aruba', '0', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AFG', 'อัฟกานิสถาน', 'Afghanistan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AGO', 'แองโกลา', 'Angola', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AIA', 'แองกวิลลา', 'Anguilla', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ALA', 'หมู่เกาะโอลันด์', 'Åland Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ALB', 'แอลเบเนีย', 'Albania', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AND', 'อันดอร์รา', 'Andorra', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ANT', 'เนเธอแลนด์แอนทิลลิส ', 'Netherlands Antilles', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ARE', 'สหรัฐอาหรับเอมิเรตส์', 'United Arab Emirates', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ARG', 'อาร์เจตินา', 'Argentina', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ARM', 'อาร์เมเนีย', 'Armenia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ASM', 'อเมริกันซามัว', 'American Samoa', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ATA', 'แอนตาร์กติกา', 'Antarctica', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ATG', 'แอนติกาและบาร์บูดา ', 'Antigua and Barbuda', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AUS', 'ออสเตรเลีย', 'Australia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AUT', 'ออสเตรีย ', 'Austria', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'AZE', 'อาร์เซอร์ไบจาน', 'Azerbaijan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BDI', 'บุรุนดี', 'Burundi', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BEL', 'เบลเยี่ยม', 'Belgium', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BEN', 'เบนิน', 'Benin', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BES', 'โบแนเรอซินต์เอิสตาซียึสและซาบา ', 'Bonaire, Sint Eustatius and Saba', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BFA', 'บูร์กินาฟาโซ ', 'Burkina Faso', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BGD', 'บังกลาเทศ ', 'Bangladesh', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BGR', 'บัลแกเรีย', 'Bulgaria', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BHR', 'บาห์เรน', 'Bahrain', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BHS', 'บาฮามาส ', 'Bahamas', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BIH', 'บอสเนียและเฮอร์เซโกวีนา', 'Bosnia and Herzegovina', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BLM', 'แซ็งบาร์เตเลมี', 'Saint Barthélemy', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BLR', 'เบลารุส', 'Belarus', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BLZ', 'เบลีซ์', 'Belize', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BMU', 'เบอร์มิวดา', 'Bermuda', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BOL', 'รัฐพหุชนชาติแห่งโบลิเวีย', 'Plurinational State of Bolivia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BRA', 'บราซิล', 'Brazil', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BRB', 'บาร์เบโดส ', 'Barbados', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BRN', 'เนการาบรูไนคารุสซาลาม', 'Negara Brunei Darussalam', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BTN', 'ภูฏาน', 'Bhutan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BVT', 'เกาะยูเว', 'Bouvet Island', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'BWA', 'บอตสวานา ', 'Botswana', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CAF', 'สาธารณรัฐแอฟริกากลาง', 'Central African Republic', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CAN', 'แคนาดา', 'Canada', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CCK', 'ดินแดนหมู่เกาะโคโคส(คีลิง)', 'The Territory of Cocos (Keeling) Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CHE', 'สวิตเซอร์แลนด์', 'Switzerland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CHL', 'ชิลี', 'Chile', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CHN', 'จีน', 'China', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CIV', 'โกตดิวัวร์', 'Côte d\'Ivoire', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CMR', 'แคเมอรูน', 'Cameroon', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'COD', 'สาธารณรัฐประชาธิปไตยคองโก', 'The Democratic Republic of the Congo', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'COG', 'คองโก', 'Congo', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'COK', 'หมู่เกาะคุก ', 'Cook Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'COL', 'โคลอมเบีย ', 'Colombia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'COM', 'คอโมโรส ', 'Comoros', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CPV', 'กาบูว์ดี', 'Cabo Verde', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CRI', 'คอสตาริกา', 'Costa Rica', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CUB', 'คิวบา', 'Cuba', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CUW', 'กือราเซา/กอร์ซอว์', 'Curaçao', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CXR', 'เกาะคริสต์มาส', 'Christmas Island', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CYM', 'หมู่เกาะเคย์แมน', 'Cayman Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CYP', 'ไซปรัส', 'Cyprus', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'CZE', 'สาธารณรัฐเช็ก', 'Czech Republic', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'DEU', 'เยอรมนี', 'Germany', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'DJI', 'จิบูตี', 'Djibouti', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'DMA', 'โดมินิกา', 'Dominica', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'DNK', 'เดนมาร์ก ', 'Danmark', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'DOM', 'สหรัสโดมิกัน', 'Dominican Republic', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'DZA', 'แอลจีเรีย', 'Algeria', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ECU', 'เอกวาดอร์', 'Ecuador', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'EGY', 'อียิปต์', 'Egypt', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ERI', 'เอริเทรีย', 'Eritrea', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ESH', 'เวสเทิร์นสะฮารา', 'Western Sahara', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ESP', 'สเปน', 'Spain', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'EST', 'เอสโตเนีย', 'Estonia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ETH', 'เอธิโอเปีย', 'Ethiopia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'FIN', 'ฟินแลนด์', 'Finland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'FJI', 'ฟิจิ', 'Fiji', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'FLK', 'หมู่เกาะฟอล์กแลนด์ (มัลวีนัส)', 'Falkland Islands (Malvinas)', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'FRA', 'ฝรั่งเศส', 'France', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'FRO', 'หมู่เกาะแฟโร', 'Faroe Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'FSM', 'ไมโครนีเซีย', 'Micronesia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GAB', 'กาบอง', 'Gabon', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GBR', 'สหราชอาณาจักร', 'United Kingdom', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GEO', 'จอร์เจีย', 'Georgia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GGY', 'เกิร์นซีร์', 'Guernsey', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GHA', 'กานา', 'Ghana', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GIB', 'ยิบรอลตาร์ ', 'Gibraltar', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GIN', 'กินี', 'Guinea', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GLP', 'กวาเดอลูป', 'Guadeloupe', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GMB', 'แกมเบีย', 'Gambia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GNB', 'กินีบิสเซา', 'Guinea-Bissau', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GNQ', 'อิเควทอเรียลกินี', 'Equatorial Guinea', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GRC', 'กรีซ', 'Greece', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-18 10:49:38');
INSERT INTO `common_country` VALUES ('C01', 'GRD', 'เกรเนดา', 'Grenada', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GRL', 'กรีนแลนด์ ', 'Greenland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GTM', 'กัวเตมาลา', 'Guatemala', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GUF', 'เฟรนช์เกียนา', 'French Guiana', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GUM', 'กวม', 'Guam', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'GUY', 'กายอานา', 'Guyana', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'HKG', 'ฮ่องกง', 'Hong Kong', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'HMD', 'หมู่เกาะเฮิร์ดและหมู่เกาะแมกดอนัลด์', 'Heard and McDonald Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'HND', 'ฮอนดูรัส', 'Honduras', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'HRV', 'โครเอเซีย', 'Croatia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'HTI', 'เฮติ', 'Haiti', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'HUN', 'ฮังการี', 'Hungary', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IDN', 'อินโดนีเซีย ', 'Indonesia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IMN', 'เกาะแมน', 'Isle of Man', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IND', 'อินเดีย', 'India', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IOT', 'บริติชอินเดียนโอเชียนเทร์ริทอรี', 'British Indian Ocean Territory', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IRL', 'ไอร์แลนด์', 'Ireland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IRN', 'สาธารณรัฐอิสลามอิหร่าน', 'Islamic Republic of Iran', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'IRQ', 'อิรัก', 'Iraq', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ISL', 'ไอซ์แลนด์ ', 'Iceland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ISR', 'อิสราเอล', 'Israel', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ITA', 'อิตาลี', 'Italy', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'JAM', 'จาเมกา', 'Jamaica', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'JEY', 'เจอร์ซีย์', 'Jersey', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'JOR', 'จอร์แดน', 'Jordan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'JPN', 'ญี่ปุ่น', 'Japan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KAZ', 'คาซัคสถาน ', 'Kazakhstan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KEN', 'เคนยา', 'Kenya', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KGZ', 'คีร์กีซสถาน ', 'Kyrgyzstan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KHM', 'กัมพูชา', 'Cambodia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KIR', 'คิริบาตี', 'Kiribati', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KNA', 'เซนต์ศิตส์และเนวิส', 'Saint Kitts and Nevis', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KOR', 'เกาหลีใต้', 'Republic of Korea', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'KWT', 'คูเวต', 'Kuwait', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LAO', 'สาธารณรัฐประชาธิปไตยประชาชนลาว', 'Lao People\'s Democratic Republic', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LBN', 'เลบานอน', 'Lebanon', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LBR', 'ไลบีเรีย', 'Liberia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LBY', 'ลิเบีย', 'Libya', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LCA', 'เซนต์ลูเซีย ', 'Saint Lucia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LIE', 'ลิกเตนส์ไตน์', 'Liechtenstein', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LKA', 'ศรีลังกา', 'Sri Lanka', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LSO', 'เลโซโท', 'Lesotho', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LTU', 'ลิทัวเนีย', 'Lithuania', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LUX', 'ลักเซมเบิร์ก', 'Luxembourg', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'LVA', 'ลัตเวีย', 'Latvia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MAC', 'มาเก๊า', 'Macao', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MAF', 'แซ็ง-มาร์แต็ง', 'Saint Martin (French part)', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MAR', 'โมร็อกโก', 'Morocco', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MCO', 'โมนาโก', 'Monaco', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MDA', 'สาธารณรัฐมอลโดวา ', 'Republic of Moldova', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MDG', 'มาดากัสการ์', 'Madagascar', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MDV', 'มัลดีฟส์', 'Maldives', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MEX', 'เม็กซิโก', 'Mexico', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MHL', 'หมู่เกาะมาร์แซลล์', 'Marshall Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MKD', 'สาธารณรัฐมาซิโดเนีย', 'Republic of Macedonia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MLI', 'มาลี', 'Mali', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MLT', 'มอลตา', 'Malta', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MMR', 'พม่า', 'Myanmar', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MNE', 'มอนเตเนโกร', 'Montenegro', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MNG', 'มองโกเลีย', 'Mongolia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MNP', 'หมู่เกาะนอร์เทิร์นมาเรียนา', 'Northern Mariana Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MOZ', 'โมซัมบิก', 'Mozambique', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MRT', 'มอริเตเนีย', 'Mauritania', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MSR', 'มอนต์เซอร์รัต', 'Montserrat', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MTQ', 'มาร์ตินิก', 'Martinique', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MUS', 'เมริเซียส', 'Mauritius', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MWI', 'สาธารณรัฐมาลาวี', 'Republic of Malawi', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MYS', 'มาเลเซีย', 'Malaysia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'MYT', 'มายอต', 'Mayotte', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NAM', 'นามิเบีย', 'Namibia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NCL', 'นิวแคลิโดเนีย', 'New Caledonia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NER', 'ไนเจอร์', 'Niger', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NFK', 'เกาะนอร์ฟอล์ก', 'Norfolk Island', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NGA', 'ไนจีเรีย', 'Nigeria', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NIC', 'นิการากัว', 'Nicaragua', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NIU', 'นีอูเอ', 'Niue', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NLD', 'เนเธอแลนด์', 'Netherlands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NOR', 'นอร์เวย์', 'Norway', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NPL', 'สหพันธ์สาธารณประชาชาธิปไตยเนปาล', 'Federal Democratic Republic of Nepal', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NRU', 'นาอูรู', 'Nauru', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'NZL', 'นิวซีแลนด์', 'New Zealand', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'OMN', 'โอมาน', 'Oman', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PAK', 'ปากีสถาน', 'Pakistan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PAN', 'ปานามา', 'Panama', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PCN', 'หมู่เกาะพิตแคร์น', 'Pitcairn Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PER', 'เปรู', 'Peru', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PHL', 'ฟิลิปปินส์', 'Philippines', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PLW', 'ปาเลา', 'Palau', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PNG', 'ปาปัวนิวกินี', 'Papua New Guinea', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'POL', 'สาธารณรัฐโปแลนด์', 'Republic of Poland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PRI', 'เปอร์โตริโก ', 'Puerto Rico', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PRK', 'เกาหลีเหนือ', 'Democratic People\'s Republic of Korea', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PRT', 'โปรตุเกส', 'Portugal', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PRY', 'ปารากวัย', 'Paraguay', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PSE', 'รัฐปาเลสไตน์', 'State of Palestine', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'PYF', 'เฟรนช์โปลินีเซีย', 'French Polynesia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'QAT', 'กาตาร์', 'Qatar', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'REU', 'เรอูเนียง', 'Réunion', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ROU', 'โรมาเนีย', 'Romania', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'RUS', 'สหพันธรัฐรัสเซีย', 'Russian Federation', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'RWA', 'รวันดา', 'Rwanda', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SAU', 'ซาอุดิอาระเบีย', 'Saudi Arabia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SDN', 'ซูดาน', 'Sudan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SEN', 'เซเนกัล', 'Senegal', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SGP', 'สิงคโปร์', 'Singapore', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SGS', 'เกาะเซาท์จอร์เจียและหมู่เกาะเซาท์แซนด์วิช', 'South Georgia and the South Sandwich Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SHN', 'เซนต์เฮเลนา', 'Saint Helena', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SJM', 'สฟาลบาร์และยานไมเอน', 'Svalbard and Jan Mayen', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SLB', 'หมู่เกาะโซโลมอน', 'Solomon Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SLE', 'เซียร์ราลีโอน', 'Sierra Leone', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SLV', 'เอลซัลวาดอร์', 'El Salvador', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SMR', 'ซานมารีโน ', 'San Marino', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SOM', 'โซมาเลีย ', 'Somalia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SPM', 'แซงปีแยร์และมีเกอลง', 'Saint Pierre and Miquelon', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SRB', 'เซอร์เบีย', 'Serbia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SSD', 'ซูดานใต้ ', 'South Sudan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'STP', 'เซาตูเมและปรินซิปี', 'Sao Tome and Principe', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SUR', 'ซูรินาเม ', 'Suriname', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SVK', 'สโลวะเกีย', 'Slovakia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SVN', 'สโลวีเนีย', 'Slovenia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SWE', 'สวีเดน', 'Sweden', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SWZ', 'สวาซิแลนด์', 'Swaziland', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SXM', 'ชินต์มาร์เติน', 'Sint Maarten (Dutch part)', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SYC', 'เซเซลล์', 'Seychelles', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'SYR', 'สาธารณรัฐอาหรับซีเรีย', 'Syrian Arab Republic', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TCA', 'หมู่เกาะเติร์กและหมู่เกาะเคลอส', 'Turks and Caicos Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TCD', 'ชาด', 'Tchad', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TGO', 'โตโก', 'Togo', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'THA', 'ไทย', 'Thailand', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TJK', 'ทาจิกิสถาน ', 'Tajikistan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TKL', 'โตเกเลา', 'Tokelau', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TKM', 'เติร์กเมนิสถาน', 'Turkmenistan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TLS', 'ติมอร์-เลสเต', 'Timor-Leste', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TON', 'ตองกา', 'Tonga', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TTO', 'ตรินิแดดและโตเบโก', 'Trinidad and Tobago', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TUN', 'ตูนิเซีย', 'Tunisia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TUR', 'ตุรกี', 'Turkey', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TUV', 'ตูวาลู', 'Tuvalu', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TWN', 'ไต้หวันสาธารณรัฐจีน', 'Taiwan, Republic of China', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'TZA', 'สหสาธารณรัฐแทนซาเนีย', 'United Republic of Tanzania', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'UGA', 'ยูกันดา', 'Uganda', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'UKR', 'ยูเครน', 'Ukraine', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'URY', 'อุรุกวัย', 'Uruguay', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'USA', 'สหรัฐอเมริกา', 'United States of America', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'UZB', 'อุซเบกิสถาน', 'Uzbekistan', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VAT', 'นครรัฐวาติกัน', 'State of the Vatican City', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VCT', 'เซนต์วินเซนต์และเกรนาดีนส์', 'Saint Vincent and the Grenadines', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VEN', 'สาธารณรัฐโบลีวาร์แห่งเวเนซุเอลา', 'Bolivarian Republic of Venezuela', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VGB', 'หมู่เกาะบริติซเวอร์จิน', 'British Virgin Islands', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VIR', 'หมู่เกาะเวอร์จินของสหรัฐอเมริกา ', 'United States Virgin Islands,USVI', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VNM', 'เวียดนาม', 'Viet Nam', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'VUT', 'วานูอาตู', 'Vanuatu', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'WLF', 'วาลลิสและฟูตูนา', 'Wallis and Futuna', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'WSM', 'ซามัว', 'Samoa', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'YEM', 'เยเมน ', 'Yemen', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ZAF', 'สาธารณรัฐแอฟริกาใต้', 'Republic of South Africa', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ZMB', 'แซมเบีย ', 'Zambia', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ZWE', 'ซิมบับเว', 'Zimbabwe', '1', 'admin', '2021-07-17 14:45:01', 'admin', '2021-07-17 14:45:01');
INSERT INTO `common_country` VALUES ('C01', 'ก', 'หหหห', 'ก', '1', 'admin', '2021-07-20 10:05:18', 'admin', '2021-07-20 10:05:23');

-- ----------------------------
-- Table structure for common_currency
-- ----------------------------
DROP TABLE IF EXISTS `common_currency`;
CREATE TABLE `common_currency` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `currencyCode` varchar(30) NOT NULL,
  `currencyName` varchar(255) DEFAULT NULL,
  `exchange_rate` double(15,5) DEFAULT NULL,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`currencyCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_currency
-- ----------------------------
INSERT INTO `common_currency` VALUES ('C01', 'C-01', 'USD', '33.03600', '1', 'admin', '2021-07-20 16:51:22', 'admin', '2021-07-20 16:54:23');
INSERT INTO `common_currency` VALUES ('C01', 'C-02', 'EUR', '39.17170', '1', 'admin', '2021-07-20 16:54:49', 'admin', '2021-07-20 16:57:04');

-- ----------------------------
-- Table structure for common_customer
-- ----------------------------
DROP TABLE IF EXISTS `common_customer`;
CREATE TABLE `common_customer` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `cusCode` varchar(30) NOT NULL DEFAULT '' COMMENT 'รหัสลุกค้า',
  `businessType` varchar(30) DEFAULT '',
  `custNameTH` varchar(200) DEFAULT '' COMMENT 'ชื่อลูกค้าภาษาไทย',
  `custNameEN` varchar(200) DEFAULT '' COMMENT 'ชื่อลูค้าภาษาอังกฤษ',
  `branchCode` varchar(4) DEFAULT '',
  `branchTH` varchar(100) DEFAULT NULL,
  `branchEN` varchar(100) DEFAULT NULL,
  `creditDay` int(11) DEFAULT NULL COMMENT 'จำนวนวันเครดิต',
  `taxID` varchar(13) DEFAULT NULL COMMENT 'เลขประจำตัวผู้เสียภาษี',
  `salemanID` varchar(30) DEFAULT '' COMMENT 'รหัสพนักงานขาย',
  `addressTH` varchar(100) DEFAULT '' COMMENT 'ที่อยู่เลขที่',
  `addressEN` varchar(255) DEFAULT '' COMMENT 'เลขที่',
  `zipCode` varchar(5) DEFAULT '' COMMENT 'รหัสไปรษณีย์',
  `countryCode` varchar(30) DEFAULT '',
  `tel` varchar(100) DEFAULT '' COMMENT 'โทรศัพท์',
  `fax` varchar(100) DEFAULT '' COMMENT 'แฟกซ์',
  `mobile` varchar(100) DEFAULT '' COMMENT 'มือถือ',
  `isActive` char(1) DEFAULT '' COMMENT 'สถานะ',
  `contactName` varchar(255) DEFAULT '',
  `contactMobile` varchar(255) DEFAULT '',
  `contactEmail` varchar(255) DEFAULT '',
  `createID` varchar(30) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`cusCode`),
  KEY `FK_cus_country` (`comCode`,`countryCode`),
  KEY `FK_cus_saleman` (`comCode`,`salemanID`),
  CONSTRAINT `FK_cus_country` FOREIGN KEY (`comCode`, `countryCode`) REFERENCES `common_country` (`comCode`, `countryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_customer
-- ----------------------------
INSERT INTO `common_customer` VALUES ('C01', 'C-0001', '1', 'แอดคอร์ด ไพลอด โลจิสติคส์(ประเทศไทย) จำกัด', 'ACCORD PILOT LOGISTICS(THAILAND)CO.,LTD.', '0000', 'สำนักงานใหญ่', 'สำนักงานใหญ่', '1', '0105537009128', 'admin', 'ริมทางรถไฟสายปากน้ำ  พระโขนง คลองเตย กรุงเทพฯ', 'RIMTHANG ROT-FAI SAIPAKNAM PHRAKANONG  KLONGTOE BANGKOK', '10260', 'THA', 'ป', 'ป', 'ป', '1', 'ป', 'ป', 'x@mail.com', 'admin', '2021-07-18 15:35:55', 'admin', '2021-07-18 19:59:47');

-- ----------------------------
-- Table structure for common_port
-- ----------------------------
DROP TABLE IF EXISTS `common_port`;
CREATE TABLE `common_port` (
  `comCode` varchar(30) NOT NULL,
  `portCode` varchar(30) NOT NULL,
  `portNameTH` varchar(255) DEFAULT '',
  `portNameEN` varchar(255) DEFAULT '',
  `countryCode` varchar(30) NOT NULL DEFAULT '',
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`portCode`),
  KEY `FK_port_country` (`comCode`,`countryCode`),
  CONSTRAINT `FK_port_country` FOREIGN KEY (`comCode`, `countryCode`) REFERENCES `common_country` (`comCode`, `countryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_port
-- ----------------------------
INSERT INTO `common_port` VALUES ('C01', 'P-001', 'NEW YORK', 'NEW YORK', 'USA', '1', 'admin', '2021-07-18 10:22:04', 'admin', '2021-07-18 10:22:04');
INSERT INTO `common_port` VALUES ('C01', 'P-002', 'LIANYUNGANG', 'LIANYUNGANG', 'CHN', '1', 'admin', '2021-07-18 10:22:20', 'admin', '2021-07-18 10:22:20');

-- ----------------------------
-- Table structure for common_saleman
-- ----------------------------
DROP TABLE IF EXISTS `common_saleman`;
CREATE TABLE `common_saleman` (
  `comCode` varchar(30) DEFAULT NULL,
  `usercode` varchar(15) DEFAULT NULL,
  `employeeCode` varchar(15) DEFAULT NULL,
  `saleName` varchar(100) DEFAULT NULL,
  `saleSurname` varchar(100) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  KEY `comCode` (`comCode`,`usercode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_saleman
-- ----------------------------
INSERT INTO `common_saleman` VALUES ('C01', 'admin', 'EMP-0001', 'PISIT', 'TANGPATTANKIJRUNG', '086-668-9649', '02-674-9007', 'pisit.atl@gmal.com');

-- ----------------------------
-- Table structure for common_supplier
-- ----------------------------
DROP TABLE IF EXISTS `common_supplier`;
CREATE TABLE `common_supplier` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `supCode` varchar(30) NOT NULL DEFAULT '' COMMENT 'รหัสลุกค้า',
  `businessType` varchar(30) DEFAULT '',
  `supNameTH` varchar(200) DEFAULT '' COMMENT 'ชื่อลูกค้าภาษาไทย',
  `supNameEN` varchar(200) DEFAULT '' COMMENT 'ชื่อลูค้าภาษาอังกฤษ',
  `branchCode` varchar(4) DEFAULT '',
  `branchTH` varchar(100) DEFAULT NULL,
  `branchEN` varchar(100) DEFAULT NULL,
  `taxID` varchar(13) DEFAULT NULL COMMENT 'เลขประจำตัวผู้เสียภาษี',
  `addressTH` varchar(100) DEFAULT '' COMMENT 'ที่อยู่เลขที่',
  `addressEN` varchar(255) DEFAULT '' COMMENT 'เลขที่',
  `zipCode` varchar(5) DEFAULT '' COMMENT 'รหัสไปรษณีย์',
  `countryCode` varchar(30) DEFAULT '',
  `tel` varchar(100) DEFAULT '' COMMENT 'โทรศัพท์',
  `fax` varchar(100) DEFAULT '' COMMENT 'แฟกซ์',
  `mobile` varchar(100) DEFAULT '' COMMENT 'มือถือ',
  `isActive` char(1) DEFAULT '' COMMENT 'สถานะ',
  `contactName` varchar(255) DEFAULT '',
  `contactMobile` varchar(255) DEFAULT '',
  `contactEmail` varchar(255) DEFAULT '',
  `createID` varchar(30) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`supCode`) USING BTREE,
  KEY `FK_cus_country` (`comCode`,`countryCode`),
  KEY `FK_cus_saleman` (`comCode`),
  CONSTRAINT `common_supplier_ibfk_1` FOREIGN KEY (`comCode`, `countryCode`) REFERENCES `common_country` (`comCode`, `countryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_supplier
-- ----------------------------
INSERT INTO `common_supplier` VALUES ('C01', 'S-0001', '1', 'MTK GLOBAL LOGISTICS', 'MTK GLOBAL LOGISTICS', '', '', '', '', '', '', '', 'GRC', '', '', '', '1', '', '', '', 'admin', '2021-07-19 08:53:22', 'admin', '2021-07-19 08:53:22');

-- ----------------------------
-- Table structure for common_transporttype
-- ----------------------------
DROP TABLE IF EXISTS `common_transporttype`;
CREATE TABLE `common_transporttype` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `transportCode` varchar(30) NOT NULL,
  `transportName` varchar(255) DEFAULT NULL,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`transportCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_transporttype
-- ----------------------------
INSERT INTO `common_transporttype` VALUES ('C01', 'T-01', 'By SEA', '1', 'admin', '2021-07-20 11:35:03', 'admin', '2021-07-20 11:35:03');
INSERT INTO `common_transporttype` VALUES ('C01', 'T-02', 'BY AIR', '1', 'admin', '2021-07-20 11:36:30', 'admin', '2021-07-20 11:36:30');
INSERT INTO `common_transporttype` VALUES ('C01', 'T-03', 'BY TRUCK', '1', 'admin', '2021-07-20 11:36:36', 'admin', '2021-07-20 11:36:36');
INSERT INTO `common_transporttype` VALUES ('C01', 'T-04', 'BY POST', '1', 'admin', '2021-07-20 11:36:42', 'admin', '2021-07-20 11:36:42');

-- ----------------------------
-- Table structure for common_unit
-- ----------------------------
DROP TABLE IF EXISTS `common_unit`;
CREATE TABLE `common_unit` (
  `comCode` varchar(30) NOT NULL DEFAULT '',
  `unitCode` varchar(30) NOT NULL,
  `unitName` varchar(255) DEFAULT NULL,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`unitCode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_unit
-- ----------------------------
INSERT INTO `common_unit` VALUES ('C01', 'U-01', 'Box', '1', 'admin', '2021-07-20 14:00:29', 'admin', '2021-07-20 14:00:29');
INSERT INTO `common_unit` VALUES ('C01', 'U-02', 'Piece', '1', 'admin', '2021-07-20 14:00:34', 'admin', '2021-07-20 14:00:34');
INSERT INTO `common_unit` VALUES ('C01', 'U-03', 'Packges', '1', 'admin', '2021-07-20 14:00:41', 'admin', '2021-07-20 14:00:41');
INSERT INTO `common_unit` VALUES ('C01', 'U-04', 'Kgs.', '1', 'admin', '2021-07-20 14:00:47', 'admin', '2021-07-20 14:00:47');
INSERT INTO `common_unit` VALUES ('C01', 'U-05', 'Cbm.', '1', 'admin', '2021-07-20 14:00:52', 'admin', '2021-07-20 14:00:52');

-- ----------------------------
-- Table structure for common_vattype
-- ----------------------------
DROP TABLE IF EXISTS `common_vattype`;
CREATE TABLE `common_vattype` (
  `comCode` varchar(30) NOT NULL,
  `typeCode` varchar(30) NOT NULL,
  `typeName` varchar(255) DEFAULT '',
  `amount` double(15,2) DEFAULT 0.00,
  `isActive` char(1) DEFAULT '',
  `createID` varchar(30) DEFAULT '',
  `createTime` datetime DEFAULT NULL,
  `editID` varchar(30) DEFAULT NULL,
  `editTime` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`typeCode`) USING BTREE,
  KEY `FK_port_country` (`comCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of common_vattype
-- ----------------------------
INSERT INTO `common_vattype` VALUES ('C01', 'T-01', 'Vat', '0.00', '1', 'admin', '2021-07-19 11:37:45', 'admin', '2021-07-19 12:04:06');
INSERT INTO `common_vattype` VALUES ('C01', 'T-02', 'Withholding Tax', '0.00', '1', 'admin', '2021-07-19 11:37:45', 'admin', '2021-07-19 12:04:06');

-- ----------------------------
-- Table structure for ref_active
-- ----------------------------
DROP TABLE IF EXISTS `ref_active`;
CREATE TABLE `ref_active` (
  `comCode` varchar(30) NOT NULL,
  `code` varchar(30) NOT NULL,
  `acttiveName` varchar(255) DEFAULT '',
  PRIMARY KEY (`comCode`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ref_active
-- ----------------------------
INSERT INTO `ref_active` VALUES ('C01', '0', 'InActive');
INSERT INTO `ref_active` VALUES ('C01', '1', 'Active');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `comCode` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '',
  `usercode` varchar(15) COLLATE utf8_bin NOT NULL,
  `username` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `userpass` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `userTypecode` int(1) DEFAULT NULL,
  `userstatus` int(1) DEFAULT NULL,
  `usercreate` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `datecreate` datetime DEFAULT NULL,
  PRIMARY KEY (`comCode`,`usercode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('C01', 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'สุพจน์ ', 'นิมะลา', null, '1', '', null);
