CREATE TABLE `item_master` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL
) ;

ALTER TABLE `item_master`
 ADD PRIMARY KEY (`item_id`);

ALTER TABLE `item_master`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;


CREATE TABLE `item_stock` (
  `item_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL
);

ALTER TABLE `item_stock`
 ADD PRIMARY KEY (`item_id`);

CREATE TABLE `item_history` (
  `history_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `create_datetime` datetime DEFAULT NULL
);

ALTER TABLE `item_history`
 ADD PRIMARY KEY (`history_id`);

ALTER TABLE `item_history`
MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
