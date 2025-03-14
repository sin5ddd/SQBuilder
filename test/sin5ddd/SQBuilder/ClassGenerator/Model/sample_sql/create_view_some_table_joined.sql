CREATE VIEW `estate_sale_all` AS
SELECT `seb`.`id`                  AS `building_id`,
       `seb`.`on_sale`             AS `on_sale`,
       `seb`.`is_recommend`        AS `is_recommend`,
       `seb`.`category`            AS `category`,
       `seb`.`registered_at`       AS `registered_at`,
       `seb`.`price`               AS `price`,
       `seb`.`manage_cost`         AS `manage_cost`,
       `seb`.`maintenance_cost`    AS `maintainance_cost`,
       `seb`.`building_name`       AS `building_name`,
       `seb`.`building_name_alt`   AS `building_name_alt`,
       `seb`.`zip_code`            AS `zip_code`,
       `seb`.`pref`                AS `pref`,
       `seb`.`city`                AS `city`,
       `seb`.`town`                AS `town`,
       `seb`.`street`              AS `street`,
       `seb`.`address_etc`         AS `address_etc`,
       `seb`.`address_alt`         AS `address_alt`,
       `seb`.`area`                AS `area`,
       `seb`.`access1`             AS `access1`,
       `seb`.`access2`             AS `access2`,
       `seb`.`lnd_square`          AS `lnd_square`,
       `seb`.`bld_square`          AS `bld_square`,
       `seb`.`room_square`         AS `room_square`,
       `seb`.`bal_square`          AS `bal_square`,
       `seb`.`elm_school`          AS `elm_school`,
       `seb`.`jrh_school`          AS `jrh_school`,
       `seb`.`trade_term_category` AS `trade_term_category`,
       `seb`.`trade_term`          AS `trade_term`,
       `seb`.`trade_period`        AS `trade_period`,
       `seb`.`sales_point`         AS `sales_point`,
       `seb`.`behavior`            AS `behavior`,
       `seb`.`latitude`            AS `latitude`,
       `seb`.`longitude`           AS `longitude`,
       `seb`.`created_at`          AS `created_at`,
       `seb`.`updated_at`          AS `updated_at`,
       `seb`.`ended_at`            AS `ended_at`,
       `seb`.`search_text`         AS `search_text`,
       `seb`.`dealer`              AS `dealer`,
       `sef`.`facility1`           AS `facility1`,
       `sef`.`facility2`           AS `facility2`,
       `sef`.`facility3`           AS `facility3`,
       `sef`.`facility4`           AS `facility4`,
       `sef`.`facility5`           AS `facility5`,
       `sef`.`facility6`           AS `facility6`,
       `sef`.`facility7`           AS `facility7`,
       `sef`.`facility8`           AS `facility8`,
       `sef`.`facility9`           AS `facility9`,
       `sef`.`facility10`          AS `facility10`,
       `sed`.`desc1`               AS `desc1`,
       `sed`.`desc2`               AS `desc2`,
       `sed`.`desc3`               AS `desc3`,
       `sed`.`desc4`               AS `desc4`,
       `sed`.`desc5`               AS `desc5`,
       `sed`.`desc6`               AS `desc6`,
       `sed`.`desc7`               AS `desc7`,
       `sed`.`desc8`               AS `desc8`,
       `sed`.`desc9`               AS `desc9`,
       `sed`.`desc10`              AS `desc10`,
       `sed`.`flyer`               AS `flyer`,
       `sei`.`img1`                AS `img1`,
       `sei`.`img1_comment`        AS `img1_comment`,
       `sei`.`img2`                AS `img2`,
       `sei`.`img2_comment`        AS `img2_comment`,
       `sei`.`img3`                AS `img3`,
       `sei`.`img3_comment`        AS `img3_comment`,
       `sei`.`img4`                AS `img4`,
       `sei`.`img4_comment`        AS `img4_comment`,
       `sei`.`img5`                AS `img5`,
       `sei`.`img5_comment`        AS `img5_comment`,
       `sei`.`img6`                AS `img6`,
       `sei`.`img6_comment`        AS `img6_comment`,
       `sei`.`img7`                AS `img7`,
       `sei`.`img7_comment`        AS `img7_comment`,
       `sei`.`img8`                AS `img8`,
       `sei`.`img8_comment`        AS `img8_comment`,
       `sei`.`img9`                AS `img9`,
       `sei`.`img9_comment`        AS `img9_comment`,
       `sei`.`img10`               AS `img10`,
       `sei`.`img10_comment`       AS `img10_comment`,
       `sei`.`youtube1`            AS `youtube1`,
       `sei`.`youtube1_comment`    AS `youtube1_comment`,
       `sei`.`youtube2`            AS `youtube2`,
       `sei`.`youtube2_comment`    AS `youtube2_comment`,
       `sei`.`theta_title1`        AS `theta_title1`,
       `sei`.`theta_url1`          AS `theta_url1`,
       `sei`.`theta_title2`        AS `theta_title2`,
       `sei`.`theta_url2`          AS `theta_url2`
FROM (((`sale_estate_base` `seb`
	JOIN `sale_estate_facility` `sef` ON (`seb`.`id` = `sef`.`building_id`))
	JOIN `sale_estate_desc` `sed` ON (`seb`.`id` = `sed`.`building_id`))
	JOIN `sale_estate_image` `sei` ON (`seb`.`id` = `sei`.`building_id`));