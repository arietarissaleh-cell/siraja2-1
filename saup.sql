/*
Navicat PGSQL Data Transfer

Source Server         : PostgreSQL
Source Server Version : 90103
Source Host           : localhost:5432
Source Database       : db_tebang_angkut
Source Schema         : saup

Target Server Type    : PGSQL
Target Server Version : 90103
File Encoding         : 65001

Date: 2016-05-29 13:19:07
*/


-- ----------------------------
-- Sequence structure for app_menus_id_app_menu_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "saup"."app_menus_id_app_menu_seq";
CREATE SEQUENCE "saup"."app_menus_id_app_menu_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Sequence structure for ms_operator_id_ms_operator_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "saup"."ms_operator_id_ms_operator_seq";
CREATE SEQUENCE "saup"."ms_operator_id_ms_operator_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 15
 CACHE 1;
SELECT setval('"saup"."ms_operator_id_ms_operator_seq"', 15, true);

-- ----------------------------
-- Sequence structure for ms_operator_privilege_id_privilege_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "saup"."ms_operator_privilege_id_privilege_seq";
CREATE SEQUENCE "saup"."ms_operator_privilege_id_privilege_seq"
 INCREMENT 1
 MINVALUE 1
 MAXVALUE 9223372036854775807
 START 1
 CACHE 1;

-- ----------------------------
-- Table structure for app_menus
-- ----------------------------
DROP TABLE IF EXISTS "saup"."app_menus";
CREATE TABLE "saup"."app_menus" (
"id_app_menu" int4 DEFAULT nextval('"saup".app_menus_id_app_menu_seq'::regclass) NOT NULL,
"title" varchar(50) COLLATE "default",
"url" varchar(100) COLLATE "default",
"icon" varchar(30) COLLATE "default",
"color_code" varchar(20) COLLATE "default",
"fid_app_menu" int2 DEFAULT 0,
"order_by" int2 DEFAULT 0,
"description" varchar(100) COLLATE "default",
"kode" varchar(10) COLLATE "default",
"app_type" int2
)
WITH (OIDS=FALSE)

;
COMMENT ON COLUMN "saup"."app_menus"."app_type" IS '1 = BackEnd;
2 = FrontEnd;';

-- ----------------------------
-- Records of app_menus
-- ----------------------------
INSERT INTO "saup"."app_menus" VALUES ('1', 'Dashboard', 'main/dashboard', 'icon-projector-screen-line', null, '0', '1', null, null, null);
INSERT INTO "saup"."app_menus" VALUES ('2', 'Master', null, 'icon-inbox-3', null, '0', '2', null, null, null);
INSERT INTO "saup"."app_menus" VALUES ('3', 'Operator', 'utilities/operator', 'icon-user-1', null, '2', '1', null, null, null);

-- ----------------------------
-- Table structure for ms_operator
-- ----------------------------
DROP TABLE IF EXISTS "saup"."ms_operator";
CREATE TABLE "saup"."ms_operator" (
"id_ms_operator" int4 DEFAULT nextval('"saup".ms_operator_id_ms_operator_seq'::regclass) NOT NULL,
"username" varchar(32) COLLATE "default",
"pwd" varchar(32) COLLATE "default",
"last_update" timestamp(6),
"expiry_date" date,
"uid" varbit(32),
"status" int2
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of ms_operator
-- ----------------------------
INSERT INTO "saup"."ms_operator" VALUES ('1', 'admin', '9de2272d87dc158742d62dfe7a0fe85a', '2016-05-28 00:00:00', '2016-12-31', E'', null);
INSERT INTO "saup"."ms_operator" VALUES ('11', 'siraja', '9de2272d87dc158742d62dfe7a0fe85a', '2016-05-28 00:00:00', '2016-12-31', null, null);
INSERT INTO "saup"."ms_operator" VALUES ('15', 'ricky', '8fce2616242fc3b6b64c5eb5ea0e26ed', '2016-05-28 00:00:00', '2016-05-28', null, null);

-- ----------------------------
-- Table structure for ms_operator_privilege
-- ----------------------------
DROP TABLE IF EXISTS "saup"."ms_operator_privilege";
CREATE TABLE "saup"."ms_operator_privilege" (
"id_privilege" int4 DEFAULT nextval('"saup".ms_operator_privilege_id_privilege_seq'::regclass) NOT NULL,
"fid_operator" int4 DEFAULT 0,
"fid_app_menu" int4 DEFAULT 0
)
WITH (OIDS=FALSE)

;

-- ----------------------------
-- Records of ms_operator_privilege
-- ----------------------------
INSERT INTO "saup"."ms_operator_privilege" VALUES ('1', '1', '1');
INSERT INTO "saup"."ms_operator_privilege" VALUES ('2', '1', '2');
INSERT INTO "saup"."ms_operator_privilege" VALUES ('3', '1', '3');

-- ----------------------------
-- Alter Sequences Owned By 
-- ----------------------------
ALTER SEQUENCE "saup"."app_menus_id_app_menu_seq" OWNED BY "app_menus"."id_app_menu";
ALTER SEQUENCE "saup"."ms_operator_id_ms_operator_seq" OWNED BY "ms_operator"."id_ms_operator";
ALTER SEQUENCE "saup"."ms_operator_privilege_id_privilege_seq" OWNED BY "ms_operator_privilege"."id_privilege";

-- ----------------------------
-- Primary Key structure for table app_menus
-- ----------------------------
ALTER TABLE "saup"."app_menus" ADD PRIMARY KEY ("id_app_menu");

-- ----------------------------
-- Primary Key structure for table ms_operator
-- ----------------------------
ALTER TABLE "saup"."ms_operator" ADD PRIMARY KEY ("id_ms_operator");
