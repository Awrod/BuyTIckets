# BuyTIckets
简易PHP购票平台
数据库结构:
/*
Navicat MySQL Data Transfer

Source Server         : aa
Source Server Version : 50717
Source Host           : localhost:3306
Source Database       : fleamarket

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2021-03-09 15:06:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for book_table
-- ----------------------------
DROP TABLE IF EXISTS `book_table`;
CREATE TABLE `book_table` (
  `BookId` int(11) NOT NULL AUTO_INCREMENT COMMENT '书籍编号',
  `BookName` varchar(60) NOT NULL COMMENT '书籍名',
  `BookType` varchar(20) NOT NULL COMMENT '书籍类别',
  `BookSubarea` varchar(20) NOT NULL COMMENT '书籍所在分区',
  `BookQuantity` int(11) NOT NULL,
  `BookPhoto` varchar(200) NOT NULL,
  `BookSynopsis` varchar(200) NOT NULL,
  `BookState` varchar(20) NOT NULL COMMENT '状态',
  PRIMARY KEY (`BookId`),
  KEY `BookName` (`BookName`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for border_table
-- ----------------------------
DROP TABLE IF EXISTS `border_table`;
CREATE TABLE `border_table` (
  `BorderId` int(11) NOT NULL AUTO_INCREMENT,
  `BorderbName` varchar(20) NOT NULL COMMENT '借阅人',
  `BorderbokName` varchar(200) NOT NULL COMMENT '借阅书籍名',
  `BorderSubarea` varchar(20) NOT NULL DEFAULT '' COMMENT '借阅书籍所在分区',
  `BorderState` varchar(20) NOT NULL COMMENT '状态',
  `BorderTime` datetime NOT NULL COMMENT '借阅时间',
  PRIMARY KEY (`BorderId`),
  KEY `BorderbokName` (`BorderbokName`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for comment_table
-- ----------------------------
DROP TABLE IF EXISTS `comment_table`;
CREATE TABLE `comment_table` (
  `CommentId` int(11) NOT NULL AUTO_INCREMENT,
  `CommentMain` varchar(200) NOT NULL,
  `CommentUsername` varchar(20) NOT NULL,
  `CommentGoodsid` int(20) NOT NULL,
  `CommentDate` datetime NOT NULL,
  PRIMARY KEY (`CommentId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for da_table
-- ----------------------------
DROP TABLE IF EXISTS `da_table`;
CREATE TABLE `da_table` (
  `DaId` int(11) NOT NULL AUTO_INCREMENT,
  `DaUserName` varchar(20) NOT NULL COMMENT '收货人名称',
  `UserMoblie` varchar(20) NOT NULL COMMENT '收货手机号',
  `UserAddr` varchar(200) NOT NULL COMMENT '收货地址',
  `DaName` varchar(255) NOT NULL,
  PRIMARY KEY (`DaId`),
  KEY `DaUserName` (`DaUserName`),
  KEY `UserMoblie` (`UserMoblie`),
  CONSTRAINT `DaUserName` FOREIGN KEY (`DaUserName`) REFERENCES `user_table` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for favorites_table
-- ----------------------------
DROP TABLE IF EXISTS `favorites_table`;
CREATE TABLE `favorites_table` (
  `FavoritesId` int(11) NOT NULL AUTO_INCREMENT COMMENT '收藏夹编号',
  `GoodsName` varchar(200) NOT NULL COMMENT '商品名称',
  `GoodsPhoto` varchar(200) NOT NULL COMMENT '商品图片',
  `FavoritesUserName` varchar(15) NOT NULL COMMENT '用户名',
  `GoodsId` int(11) NOT NULL,
  PRIMARY KEY (`FavoritesId`),
  KEY `GoodsPhoto` (`GoodsPhoto`),
  KEY `FavoritesUserName` (`FavoritesUserName`),
  KEY `GoodsName` (`GoodsName`),
  CONSTRAINT `FavoritesUserName` FOREIGN KEY (`FavoritesUserName`) REFERENCES `user_table` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `GoodsName` FOREIGN KEY (`GoodsName`) REFERENCES `goods_table` (`GoodsName`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `GoodsPhoto` FOREIGN KEY (`GoodsPhoto`) REFERENCES `goods_table` (`GoodsPhoto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for goods_table
-- ----------------------------
DROP TABLE IF EXISTS `goods_table`;
CREATE TABLE `goods_table` (
  `GoodsId` int(11) NOT NULL AUTO_INCREMENT,
  `GoodsPhoto` varchar(200) NOT NULL COMMENT '商品图片',
  `GoodsName` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `GoodsType` varchar(20) NOT NULL COMMENT '商品类别',
  `GoodsQuantity` int(11) NOT NULL COMMENT '商品数量',
  `GoodsSynopsis` varchar(150) DEFAULT NULL COMMENT '商品介绍',
  `GoodsState` varchar(20) NOT NULL,
  `GoodsPrice` decimal(10,2) NOT NULL COMMENT '商品价格',
  `UserName` varchar(20) NOT NULL COMMENT '卖家名',
  `GoodsPhotoo` varchar(200) NOT NULL COMMENT '商品图详情图一',
  `GoodsPhotot` varchar(200) NOT NULL COMMENT '商品图详情图二',
  `GoodsPhotos` varchar(200) NOT NULL COMMENT '商品图详情图三',
  PRIMARY KEY (`GoodsId`),
  KEY `UserName` (`UserName`),
  KEY `GoodsName` (`GoodsName`),
  KEY `GoodsPhoto` (`GoodsPhoto`),
  CONSTRAINT `UserName` FOREIGN KEY (`UserName`) REFERENCES `user_table` (`userName`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for order_table
-- ----------------------------
DROP TABLE IF EXISTS `order_table`;
CREATE TABLE `order_table` (
  `OrderId` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单编号',
  `OrderGid` int(11) NOT NULL COMMENT '商品id',
  `OrdergName` varchar(100) NOT NULL COMMENT '商品名',
  `OrderPrice` decimal(10,2) NOT NULL COMMENT '商品价格',
  `OrderbName` varchar(15) NOT NULL COMMENT '买家名称',
  `OrdersName` varchar(15) NOT NULL COMMENT '卖家名称',
  `OrderAddr` varchar(200) NOT NULL COMMENT '收获地址',
  `OrderMoblie` varchar(11) NOT NULL COMMENT '收件手机号',
  `OrderDate` datetime NOT NULL,
  `OrderbState` varchar(20) NOT NULL COMMENT '买家订单状态',
  `OrdersState` varchar(20) NOT NULL COMMENT '卖家家订单状态',
  `OrderUserN` varchar(20) NOT NULL COMMENT '买家用户名',
  `OrdergQuantity` int(11) NOT NULL COMMENT '购买商品数量',
  PRIMARY KEY (`OrderId`),
  KEY `OrdergName` (`OrdergName`),
  KEY `OrderMoblie` (`OrderMoblie`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for shoppingcart_table
-- ----------------------------
DROP TABLE IF EXISTS `shoppingcart_table`;
CREATE TABLE `shoppingcart_table` (
  `ShoppingId` int(11) NOT NULL AUTO_INCREMENT,
  `ShoppingGid` int(11) NOT NULL,
  `ShoppingGname` varchar(100) NOT NULL,
  `ShoppingPrice` decimal(10,2) NOT NULL,
  `ShoppingSname` varchar(20) NOT NULL,
  `ShoppingQuantity` int(11) NOT NULL,
  `ShoppingGphoto` varchar(255) NOT NULL,
  `ShoppingUsername` varchar(20) NOT NULL,
  PRIMARY KEY (`ShoppingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for user_table
-- ----------------------------
DROP TABLE IF EXISTS `user_table`;
CREATE TABLE `user_table` (
  `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户编号',
  `userName` varchar(15) NOT NULL COMMENT '用户名',
  `userPass` varchar(10) NOT NULL COMMENT '用户密码',
  `userSex` varchar(6) DEFAULT NULL COMMENT '用户性别',
  `userMoblie` varchar(11) NOT NULL COMMENT '用户手机号',
  `userType` varchar(10) NOT NULL COMMENT '用户类别',
  `userPhoto` varchar(150) DEFAULT NULL,
  `userState` varchar(20) DEFAULT NULL COMMENT '状态',
  `userLevel` decimal(11,0) DEFAULT NULL COMMENT '商家店铺信用',
  `userReallyn` varchar(10) NOT NULL,
  `useridcard` varchar(18) NOT NULL,
  PRIMARY KEY (`userId`),
  KEY `user_name` (`userName`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
