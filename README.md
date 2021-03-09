# BuyTIckets
简易PHP购票平台
数据库结构:
/*
Navicat MySQL Data Transfer

Source Server         : aa
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : buytlckets_db

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2021-03-09 15:09:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for comment_table
-- ----------------------------
DROP TABLE IF EXISTS `comment_table`;
CREATE TABLE `comment_table` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_name` varchar(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `comment_main` varchar(150) NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for information_table
-- ----------------------------
DROP TABLE IF EXISTS `information_table`;
CREATE TABLE `information_table` (
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `information_user_name` varchar(20) NOT NULL COMMENT '购买用户信息',
  `information_ticket_name` varchar(20) NOT NULL COMMENT '购票票名',
  `information_ticket_price` decimal(10,2) DEFAULT NULL,
  `information_ticket_date` datetime DEFAULT NULL,
  `ticket_type` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`information_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for ticket_table
-- ----------------------------
DROP TABLE IF EXISTS `ticket_table`;
CREATE TABLE `ticket_table` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '票编号',
  `ticket_name` varchar(50) NOT NULL COMMENT '票名',
  `ticket_price` varchar(10) NOT NULL COMMENT '票价',
  `tiket_type` varchar(10) NOT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user_table
-- ----------------------------
DROP TABLE IF EXISTS `user_table`;
CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(10) NOT NULL DEFAULT '' COMMENT '用户名限制长度',
  `user_pass` varchar(51) NOT NULL COMMENT '密码长度限制10个字符',
  `user_phone` varchar(15) NOT NULL,
  `user_idcard` varchar(23) NOT NULL COMMENT '身份证',
  `user_Invite` varchar(20) DEFAULT NULL,
  `user_integral` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
