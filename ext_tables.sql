#
# Table structure for table 'tx_contenttargeting_persona'
#
CREATE TABLE tx_contenttargeting_persona (
	uid int(11) NOT NULL auto_increment,

	cookie_id varchar(255) DEFAULT '' NOT NULL,
	tracking int(1) NOT NULL DEFAULT '1',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY `cookie_id` (`cookie_id`) USING BTREE
);

#
# Table structure for table 'tx_contenttargeting_persona'
#
CREATE TABLE tx_contenttargeting_persona_interests (
	uid int(11) NOT NULL auto_increment,

	persona_uid int(11) NOT NULL default '0',
	category_uid int(11) NOT NULL default '0',
	weight int(5) NOT NULL default '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY `persona_uid` (`persona_uid`) USING BTREE
);
#
# Table structure for table 'tx_contenttargeting_targets'
#
CREATE TABLE tx_contenttargeting_targets (

	uid int(11) NOT NULL auto_increment,
	foreign_table varchar(255) NOT NULL default '',
	foreign_uid int(11) NOT NULL default '0',
	`cat_1` int(1) NOT NULL DEFAULT '0',
	`cat_2` int(1) NOT NULL DEFAULT '0',
	`cat_3` int(1) NOT NULL DEFAULT '0',
	`cat_4` int(1) NOT NULL DEFAULT '0',
	`cat_5` int(1) NOT NULL DEFAULT '0',
	`cat_6` int(1) NOT NULL DEFAULT '0',
	`cat_7` int(1) NOT NULL DEFAULT '0',
	`cat_8` int(1) NOT NULL DEFAULT '0',
	`cat_9` int(1) NOT NULL DEFAULT '0',
	`cat_10` int(1) NOT NULL DEFAULT '0',
	`cat_11` int(1) NOT NULL DEFAULT '0',
	`cat_12` int(1) NOT NULL DEFAULT '0',
	`cat_13` int(1) NOT NULL DEFAULT '0',
	`cat_14` int(1) NOT NULL DEFAULT '0',
	`cat_15` int(1) NOT NULL DEFAULT '0',
	`cat_16` int(1) NOT NULL DEFAULT '0',
	`cat_17` int(1) NOT NULL DEFAULT '0',
	`cat_18` int(1) NOT NULL DEFAULT '0',
	`cat_19` int(1) NOT NULL DEFAULT '0',
	`cat_20` int(1) NOT NULL DEFAULT '0',
	`cat_21` int(1) NOT NULL DEFAULT '0',
	`cat_22` int(1) NOT NULL DEFAULT '0',
	`cat_23` int(1) NOT NULL DEFAULT '0',
	`cat_24` int(1) NOT NULL DEFAULT '0',
	`cat_25` int(1) NOT NULL DEFAULT '0',
	`cat_26` int(1) NOT NULL DEFAULT '0',
	`cat_27` int(1) NOT NULL DEFAULT '0',
	`cat_28` int(1) NOT NULL DEFAULT '0',
	`cat_29` int(1) NOT NULL DEFAULT '0',
	`cat_30` int(1) NOT NULL DEFAULT '0',
	`cat_31` int(1) NOT NULL DEFAULT '0',
	`cat_32` int(1) NOT NULL DEFAULT '0',
	`cat_33` int(1) NOT NULL DEFAULT '0',
	`cat_34` int(1) NOT NULL DEFAULT '0',
	`cat_35` int(1) NOT NULL DEFAULT '0',
	`cat_36` int(1) NOT NULL DEFAULT '0',
	`cat_37` int(1) NOT NULL DEFAULT '0',
	`cat_38` int(1) NOT NULL DEFAULT '0',
	`cat_39` int(1) NOT NULL DEFAULT '0',
	`cat_40` int(1) NOT NULL DEFAULT '0',
	`cat_41` int(1) NOT NULL DEFAULT '0',
	`cat_42` int(1) NOT NULL DEFAULT '0',
	`cat_43` int(1) NOT NULL DEFAULT '0',
	`cat_44` int(1) NOT NULL DEFAULT '0',
	`cat_45` int(1) NOT NULL DEFAULT '0',
	`cat_46` int(1) NOT NULL DEFAULT '0',
	`cat_47` int(1) NOT NULL DEFAULT '0',
	`cat_48` int(1) NOT NULL DEFAULT '0',
	`cat_49` int(1) NOT NULL DEFAULT '0',
	`cat_50` int(1) NOT NULL DEFAULT '0',
	`cat_51` int(1) NOT NULL DEFAULT '0',
	`cat_52` int(1) NOT NULL DEFAULT '0',
	`cat_53` int(1) NOT NULL DEFAULT '0',
	`cat_54` int(1) NOT NULL DEFAULT '0',
	`cat_55` int(1) NOT NULL DEFAULT '0',
	`cat_56` int(1) NOT NULL DEFAULT '0',
	`cat_57` int(1) NOT NULL DEFAULT '0',
	`cat_58` int(1) NOT NULL DEFAULT '0',
	`cat_59` int(1) NOT NULL DEFAULT '0',
	`cat_60` int(1) NOT NULL DEFAULT '0',
	`cat_61` int(1) NOT NULL DEFAULT '0',
	`cat_62` int(1) NOT NULL DEFAULT '0',
	`cat_63` int(1) NOT NULL DEFAULT '0',
	`cat_64` int(1) NOT NULL DEFAULT '0',
	`cat_65` int(1) NOT NULL DEFAULT '0',
	`cat_66` int(1) NOT NULL DEFAULT '0',
	`cat_67` int(1) NOT NULL DEFAULT '0',
	`cat_68` int(1) NOT NULL DEFAULT '0',
	`cat_69` int(1) NOT NULL DEFAULT '0',
	`cat_70` int(1) NOT NULL DEFAULT '0',
	`cat_71` int(1) NOT NULL DEFAULT '0',
	`cat_72` int(1) NOT NULL DEFAULT '0',
	`cat_73` int(1) NOT NULL DEFAULT '0',
	`cat_74` int(1) NOT NULL DEFAULT '0',
	`cat_75` int(1) NOT NULL DEFAULT '0',
	`cat_76` int(1) NOT NULL DEFAULT '0',
	`cat_77` int(1) NOT NULL DEFAULT '0',
	`cat_78` int(1) NOT NULL DEFAULT '0',
	`cat_79` int(1) NOT NULL DEFAULT '0',
	`cat_80` int(1) NOT NULL DEFAULT '0',
	`cat_81` int(1) NOT NULL DEFAULT '0',
	`cat_82` int(1) NOT NULL DEFAULT '0',
	`cat_83` int(1) NOT NULL DEFAULT '0',
	`cat_84` int(1) NOT NULL DEFAULT '0',
	`cat_85` int(1) NOT NULL DEFAULT '0',
	`cat_86` int(1) NOT NULL DEFAULT '0',
	`cat_87` int(1) NOT NULL DEFAULT '0',
	`cat_88` int(1) NOT NULL DEFAULT '0',
	`cat_89` int(1) NOT NULL DEFAULT '0',
	`cat_90` int(1) NOT NULL DEFAULT '0',
	`cat_91` int(1) NOT NULL DEFAULT '0',
	`cat_92` int(1) NOT NULL DEFAULT '0',
	`cat_93` int(1) NOT NULL DEFAULT '0',
	`cat_94` int(1) NOT NULL DEFAULT '0',
	`cat_95` int(1) NOT NULL DEFAULT '0',
	`cat_96` int(1) NOT NULL DEFAULT '0',
	`cat_97` int(1) NOT NULL DEFAULT '0',
	`cat_98` int(1) NOT NULL DEFAULT '0',
	`cat_99` int(1) NOT NULL DEFAULT '0',
	`cat_100` int(1) NOT NULL DEFAULT '0',
	`cat_101` int(1) NOT NULL DEFAULT '0',
	`cat_102` int(1) NOT NULL DEFAULT '0',
	`cat_103` int(1) NOT NULL DEFAULT '0',
	`cat_104` int(1) NOT NULL DEFAULT '0',
	`cat_105` int(1) NOT NULL DEFAULT '0',
	`cat_106` int(1) NOT NULL DEFAULT '0',
	`cat_107` int(1) NOT NULL DEFAULT '0',
	`cat_108` int(1) NOT NULL DEFAULT '0',
	`cat_109` int(1) NOT NULL DEFAULT '0',
	`cat_110` int(1) NOT NULL DEFAULT '0',
	`cat_111` int(1) NOT NULL DEFAULT '0',
	`cat_112` int(1) NOT NULL DEFAULT '0',
	`cat_113` int(1) NOT NULL DEFAULT '0',
	`cat_114` int(1) NOT NULL DEFAULT '0',
	`cat_115` int(1) NOT NULL DEFAULT '0',
	`cat_116` int(1) NOT NULL DEFAULT '0',
	`cat_117` int(1) NOT NULL DEFAULT '0',
	`cat_118` int(1) NOT NULL DEFAULT '0',
	`cat_119` int(1) NOT NULL DEFAULT '0',
	`cat_120` int(1) NOT NULL DEFAULT '0',
	`cat_121` int(1) NOT NULL DEFAULT '0',
	`cat_122` int(1) NOT NULL DEFAULT '0',
	`cat_123` int(1) NOT NULL DEFAULT '0',
	`cat_124` int(1) NOT NULL DEFAULT '0',
	`cat_125` int(1) NOT NULL DEFAULT '0',
	`cat_126` int(1) NOT NULL DEFAULT '0',
	`cat_127` int(1) NOT NULL DEFAULT '0',
	`cat_128` int(1) NOT NULL DEFAULT '0',
	`cat_129` int(1) NOT NULL DEFAULT '0',
	`cat_130` int(1) NOT NULL DEFAULT '0',
	`cat_131` int(1) NOT NULL DEFAULT '0',
	`cat_132` int(1) NOT NULL DEFAULT '0',
	`cat_133` int(1) NOT NULL DEFAULT '0',
	`cat_134` int(1) NOT NULL DEFAULT '0',
	`cat_135` int(1) NOT NULL DEFAULT '0',
	`cat_136` int(1) NOT NULL DEFAULT '0',
	`cat_137` int(1) NOT NULL DEFAULT '0',
	`cat_138` int(1) NOT NULL DEFAULT '0',
	`cat_139` int(1) NOT NULL DEFAULT '0',
	`cat_140` int(1) NOT NULL DEFAULT '0',
	`cat_141` int(1) NOT NULL DEFAULT '0',
	`cat_142` int(1) NOT NULL DEFAULT '0',
	`cat_143` int(1) NOT NULL DEFAULT '0',
	`cat_144` int(1) NOT NULL DEFAULT '0',
	`cat_145` int(1) NOT NULL DEFAULT '0',
	`cat_146` int(1) NOT NULL DEFAULT '0',
	`cat_147` int(1) NOT NULL DEFAULT '0',
	`cat_148` int(1) NOT NULL DEFAULT '0',
	`cat_149` int(1) NOT NULL DEFAULT '0',
	`cat_150` int(1) NOT NULL DEFAULT '0',
	`cat_151` int(1) NOT NULL DEFAULT '0',
	`cat_152` int(1) NOT NULL DEFAULT '0',
	`cat_153` int(1) NOT NULL DEFAULT '0',
	`cat_154` int(1) NOT NULL DEFAULT '0',
	`cat_155` int(1) NOT NULL DEFAULT '0',
	`cat_156` int(1) NOT NULL DEFAULT '0',
	`cat_157` int(1) NOT NULL DEFAULT '0',
	`cat_158` int(1) NOT NULL DEFAULT '0',
	`cat_159` int(1) NOT NULL DEFAULT '0',
	`cat_160` int(1) NOT NULL DEFAULT '0',
	`cat_161` int(1) NOT NULL DEFAULT '0',
	`cat_162` int(1) NOT NULL DEFAULT '0',
	`cat_163` int(1) NOT NULL DEFAULT '0',
	`cat_164` int(1) NOT NULL DEFAULT '0',
	`cat_165` int(1) NOT NULL DEFAULT '0',
	`cat_166` int(1) NOT NULL DEFAULT '0',
	`cat_167` int(1) NOT NULL DEFAULT '0',
	`cat_168` int(1) NOT NULL DEFAULT '0',
	`cat_169` int(1) NOT NULL DEFAULT '0',
	`cat_170` int(1) NOT NULL DEFAULT '0',
	`cat_171` int(1) NOT NULL DEFAULT '0',
	`cat_172` int(1) NOT NULL DEFAULT '0',
	`cat_173` int(1) NOT NULL DEFAULT '0',
	`cat_174` int(1) NOT NULL DEFAULT '0',
	`cat_175` int(1) NOT NULL DEFAULT '0',
	`cat_176` int(1) NOT NULL DEFAULT '0',
	`cat_177` int(1) NOT NULL DEFAULT '0',
	`cat_178` int(1) NOT NULL DEFAULT '0',
	`cat_179` int(1) NOT NULL DEFAULT '0',
	`cat_180` int(1) NOT NULL DEFAULT '0',
	`cat_181` int(1) NOT NULL DEFAULT '0',
	`cat_182` int(1) NOT NULL DEFAULT '0',
	`cat_183` int(1) NOT NULL DEFAULT '0',
	`cat_184` int(1) NOT NULL DEFAULT '0',
	`cat_185` int(1) NOT NULL DEFAULT '0',
	`cat_186` int(1) NOT NULL DEFAULT '0',
	`cat_187` int(1) NOT NULL DEFAULT '0',
	`cat_188` int(1) NOT NULL DEFAULT '0',
	`cat_189` int(1) NOT NULL DEFAULT '0',
	`cat_190` int(1) NOT NULL DEFAULT '0',
	`cat_191` int(1) NOT NULL DEFAULT '0',
	`cat_192` int(1) NOT NULL DEFAULT '0',
	`cat_193` int(1) NOT NULL DEFAULT '0',
	`cat_194` int(1) NOT NULL DEFAULT '0',
	`cat_195` int(1) NOT NULL DEFAULT '0',
	`cat_196` int(1) NOT NULL DEFAULT '0',
	`cat_197` int(1) NOT NULL DEFAULT '0',
	`cat_198` int(1) NOT NULL DEFAULT '0',
	`cat_199` int(1) NOT NULL DEFAULT '0',
	`cat_200` int(1) NOT NULL DEFAULT '0',


	PRIMARY KEY (uid)
);
