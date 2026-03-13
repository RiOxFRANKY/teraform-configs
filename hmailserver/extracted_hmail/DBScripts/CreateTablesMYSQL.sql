drop table if exists hm_imapfolders;
drop table if exists hm_settings;
drop table if exists hm_accounts;
drop table if exists hm_aliases;
drop table if exists hm_domains;
drop table if exists hm_domain_aliases;
drop table if exists hm_messages;
drop table if exists hm_dbversion;
drop table if exists hm_serverlog;
drop table if exists hm_distributionlists;
drop table if exists hm_distributionlistsrecipients;
drop table if exists hm_messagerecipients;
drop table if exists hm_routes;
drop table if exists hm_routeaddresses;
drop table if exists hm_securityranges;
drop table if exists hm_deliverylog;
drop table if exists hm_deliverylog_recipients;
drop table if exists hm_dnsbl;
drop table if exists hm_fetchaccounts;
drop table if exists hm_fetchaccounts_uids;
drop table if exists hm_rules;
drop table if exists hm_rule_criterias;
drop table if exists hm_rule_actions;
drop table if exists hm_iphomes;
drop table if exists hm_surblservers;
drop table if exists hm_greylisting_triplets;
drop table if exists hm_blocked_attachments;
drop table if exists hm_servermessages;
drop table if exists hm_greylisting_whiteaddresses;
drop table if exists hm_tcpipports;
drop table if exists hm_adsynchronization;
drop table if exists hm_whitelist;

create table hm_accounts 
(
	accountid int auto_increment not null, primary key(`accountid`), unique(`accountid`),
	accountdomainid int not null ,
	accountadminlevel tinyint not null ,
	accountaddress varchar (255) not null, unique(`accountaddress`),
	accountpassword varchar (255) not null ,
	accountactive tinyint not null,
	accountisad tinyint not null, 
	accountaddomain varchar (255) not null ,
	accountadusername varchar (255) not null,
	accountmaxsize int not null,
	accountvacationmessageon tinyint not null,
	accountvacationmessage text not null,
	accountvacationsubject varchar (200) not null,
	accountpwencryption tinyint not null,
	accountforwardenabled tinyint not null,
	accountforwardaddress varchar (255) not null,
	accountforwardkeeporiginal tinyint not null,
	accountenablesignature tinyint not null,
	accountsignatureplaintext text not null,
	accountsignaturehtml text not null,
	accountlastlogontime datetime not null,
	accountvacationexpires tinyint unsigned not null,
	accountvacationexpiredate datetime not null
);

CREATE INDEX idx_hm_accounts ON hm_accounts (accountaddress);

create table hm_aliases 
(
	aliasid int auto_increment not null, primary key(`aliasid`), unique(`aliasid`),
	aliasdomainid int not null ,
	aliasname varchar (255) not null, unique(`aliasname`),
	aliasvalue varchar (255) not null ,
	aliasactive tinyint not null,
	aliastype tinyint not null
);

CREATE INDEX idx_hm_aliases ON hm_aliases (aliasdomainid, aliasname);

create table hm_domains 
(
	domainid int auto_increment not null, primary key(`domainid`), unique(`domainid`),
	domainname varchar (80) not null, unique(`domainname`),
	domainactive tinyint not null,
	domainpostmaster varchar (80) not null,
	domainmaxsize integer not null,
	domainaddomain varchar(255) not null,
	domainmaxmessagesize integer not null,
	domainuseplusaddressing  tinyint not null,
	domainplusaddressingchar varchar(1) not null,
	domainantispamoptions integer not null,
	domainenablesignature tinyint not null,
	domainsignaturemethod tinyint not null,
	domainsignatureplaintext text not null,
	domainsignaturehtml text not null,
	domainaddsignaturestoreplies tinyint not null,
	domainaddsignaturestolocalemail tinyint not null,
	domainmaxnoofaccounts int not null,
	domainmaxnoofaliases int not null,
	domainmaxnoofdistributionlists int not null,
	domainlimitationsenabled int not null,
	domainmaxaccountsize int not null
);

CREATE INDEX idx_hm_domains ON hm_domains (domainname);

create table hm_domain_aliases
(
	daid int auto_increment not null, primary key(`daid`), unique(`daid`),
	dadomainid int not null ,
	daalias varchar(255) not null
);

create table hm_messages 
(
	messageid bigint auto_increment not null, primary key(`messageid`), unique(`messageid`),
	messageaccountid int not null ,
	messagefolderid integer not null DEFAULT 0,
	messagefilename varchar (255) not null ,
	messagetype tinyint not null ,
	messagefrom varchar (255) not null ,
	messagerecipients text not null ,
	messagesize bigint not null,
	messagecurnooftries int not null,
	messagenexttrytime datetime not null,
	messageflagseen tinyint not null,
	messageflagdeleted tinyint not null,
	messageflagrecent tinyint not null,
	messageflaganswered tinyint not null,
	messageflagflagged tinyint not null,
	messageflagdraft tinyint not null,
	messagerecipientsparsed tinyint not null,
	messagecreatetime datetime not null,
	messagelocked tinyint not null
);

CREATE INDEX idx_hm_messages ON hm_messages (messageaccountid, messagefolderid);

CREATE INDEX idx_hm_messages_type ON hm_messages (messagetype);

create table hm_settings 
(
	settingid int auto_increment not null, primary key(`settingid`), unique(`settingid`),
	settingname varchar (30) not null, unique(`settingname`),
	settingstring varchar (255) not null ,
	settinginteger int not null
);

create table hm_dbversion 
(
	value int not null
);

create table hm_serverlog 
(
	logid int auto_increment not null, primary key(logid), unique(logid),
	logprocessid int not null,
	logthreadid int not null,		
	logsource tinyint not null,
	logtime datetime not null,
	logremotehost varchar(15) not null,
	logtext text not null
);

create table hm_distributionlists 
(
	distributionlistid int auto_increment not null, primary key(distributionlistid), unique(distributionlistid),
	distributionlistdomainid int not null,
	distributionlistaddress varchar(255) not null,unique(`distributionlistaddress`),
	distributionlistenabled tinyint not null,
   distributionlistrequireauth tinyint not null,
	distributionlistrequireaddress varchar(255) not null,
	distributionlistmode tinyint not null
);

CREATE INDEX idx_hm_distributionlists ON hm_distributionlists (distributionlistdomainid);

create table hm_distributionlistsrecipients
(
	distributionlistrecipientid int auto_increment not null, primary key(distributionlistrecipientid), unique(distributionlistrecipientid),
	distributionlistrecipientlistid int not null,
	distributionlistrecipientaddress varchar(255)	
);

CREATE INDEX idx_hm_distributionlistsrecipients ON hm_distributionlistsrecipients (distributionlistrecipientlistid);

create table hm_messagerecipients
(
	recipientid bigint auto_increment not null, primary key(recipientid), unique(recipientid),
 	recipientmessageid bigint not null,
	recipientaddress varchar(255) not null,
	recipientislocal tinyint not null,
	recipientisenabled tinyint not null,
	recipientisexisting tinyint not null,
	recipientlocalaccountid int not null	
);

CREATE INDEX idx_hm_messagerecipients ON hm_messagerecipients (recipientmessageid);

create table hm_imapfolders 
(
  folderid int NOT NULL auto_increment, primary key(folderid), unique(folderid),
  folderaccountid int unsigned NOT NULL,
  folderparentid int NOT NULL,
  foldername varchar(255) NOT NULL,
  folderissubscribed tinyint unsigned NOT NULL
);

CREATE INDEX idx_hm_imapfolders ON hm_imapfolders (folderaccountid);

create table hm_routes
(
  routeid int NOT NULL auto_increment, primary key(routeid), unique(routeid),
  routedomainname varchar(255) NOT NULL, unique(`routedomainname`),
  routetargetsmthost varchar(255) NOT NULL,
  routetargetsmtport int NOT NULL,
  routenooftries int NOT NULL,
  routeminutesbetweentry int NOT NULL,
  routealladdresses tinyint unsigned NOT NULL,
  routeuseauthentication tinyint NOT NULL,
  routeauthenticationusername varchar(255) NOT NULL,
  routeauthenticationpassword varchar(255) NOT NULL,
  routetreatsecurityaslocal tinyint NOT NULL
);

create table hm_routeaddresses
(
  routeaddressid mediumint(9) NOT NULL auto_increment, primary key(routeaddressid), unique(routeaddressid),
  routeaddressrouteid int NOT NULL,
  routeaddressaddress varchar(255) NOT NULL
);

create table hm_securityranges
(
	rangeid int auto_increment not null, primary key(rangeid), unique(rangeid),
   rangepriorityid int not null,
	rangelowerip bigint unsigned not null,
	rangeupperip bigint unsigned not null,
	rangeoptions int not null,
	rangename varchar (100) not null, unique(`rangename`)
);


insert into hm_securityranges (rangepriorityid, rangelowerip, rangeupperip, rangeoptions, rangename) values (10, 0, 4294967295, 1515, 'Internet');
insert into hm_securityranges (rangepriorityid, rangelowerip, rangeupperip, rangeoptions, rangename) values (15, 2130706433, 2130706433, 1483, 'My computer');

create table hm_deliverylog
(
	deliveryid bigint auto_increment not null, primary key(deliveryid), unique(deliveryid),
	deliveryfrom varchar(255) not null,
  	deliveryfilename varchar(255) not null,
   deliverytime datetime not null,
	deliverysubject varchar(255) not null,
	deliverybody text not null
);

create table hm_deliverylog_recipients
(
	deliveryrecipientid int auto_increment not null, primary key(deliveryrecipientid), unique(deliveryrecipientid),
   deliveryid  int not null,
	deliveryrecipientaddress varchar(255) not null
);

create table hm_dnsbl
(
	sblid int auto_increment not null, primary key(sblid), unique(sblid),
	sblactive tinyint not null,
	sbldnshost varchar(255) not null,
	sblresult varchar(255) not null,
	sblrejectmessage varchar(255) not null
);

create table hm_fetchaccounts
(	
	faid int auto_increment not null, primary key(`faid`), unique(`faid`),
	faactive tinyint not null,
	faaccountid int not null,
	faaccountname varchar (255) not null,
	faserveraddress varchar (255) not null,
	faserverport int not null,
	faservertype tinyint not null,
	fausername varchar (255) not null,
	fapassword varchar (255) not null,
	faminutes int not null,
	fanexttry datetime not null,
	fadaystokeep int not null,
	falocked tinyint not null,
	faprocessmimerecipients tinyint not null,
	faprocessmimedate tinyint not null
);

create table hm_fetchaccounts_uids
(
	uidid int auto_increment not null, primary key(`uidid`), unique(`uidid`),
	uidfaid int not null,
	uidvalue varchar(255) not null,
	uidtime datetime not null
);

CREATE INDEX idx_hm_fetchaccounts_uids ON hm_fetchaccounts_uids (uidfaid);

create table hm_rules
(
	ruleid int auto_increment not null, primary key(`ruleid`), unique(`ruleid`),
	ruleaccountid int not null,
	rulename varchar(100) not null,
	ruleactive tinyint not null,
	ruleuseand tinyint not null,
	rulesortorder int not null
);

CREATE INDEX idx_rules ON hm_rules (ruleaccountid);

create table hm_rule_criterias
(
	criteriaid int auto_increment not null, primary key(`criteriaid`), unique(`criteriaid`),
	criteriaruleid int not null,
	criteriausepredefined tinyint not null,
	criteriapredefinedfield tinyint not null,
	criteriaheadername varchar(255) not null,
	criteriamatchtype tinyint not null,
	criteriamatchvalue varchar(255) not null
	
);

CREATE INDEX idx_rules_criterias ON hm_rule_criterias (criteriaruleid);

create table hm_rule_actions
(
	actionid int auto_increment not null, primary key(`actionid`), unique(`actionid`),
	actionruleid int not null,
	actiontype tinyint not null,
	actionimapfolder varchar(255) not null,
	actionsubject varchar(255) not null,
	actionfromname varchar(255) not null,
	actionfromaddress varchar(255) not null,
	actionto varchar(255) not null,
	actionbody text not null,
	actionfilename varchar(255) not null,
	actionsortorder int not null,
	actionscriptfunction varchar(255) not null,
	actionrouteid int not null
);

CREATE INDEX idx_rules_actions ON hm_rule_actions (actionruleid);

create table hm_adsynchronization
(
	synchid int auto_increment not null, primary key(`synchid`), unique(`synchid`),
	synchaccountid int not null,
	synchguid varchar(50) not null
);

create table hm_iphomes
(
	iphomeid int auto_increment not null, primary key(`iphomeid`), unique(`iphomeid`),
	iphomeaddress bigint unsigned not null
);

create table hm_surblservers
(
	surblid int auto_increment not null, primary key(surblid), unique(surblid),
	surblactive tinyint not null,
	surblhost varchar(255) not null,
	surblrejectmessage varchar(255) not null
);

create table hm_greylisting_triplets
(
	glid bigint auto_increment not null, primary key(glid), unique(glid),
	glcreatetime datetime not null,
	glblockendtime datetime not null,
	gldeletetime datetime not null,
	glipaddress bigint not null,
	glsenderaddress varchar(255) not null,
	glrecipientaddress varchar(255) not null,
	glblockedcount int not null,
	glpassedcount int not null
);

CREATE INDEX idx_greylisting_triplets ON hm_greylisting_triplets (glipaddress, glsenderaddress(40), glrecipientaddress(40));

create table hm_greylisting_whiteaddresses
(
	whiteid bigint auto_increment not null, primary key(whiteid), unique(whiteid),
	whiteipaddress varchar(255) not null,
	whiteipdescription varchar(255) not null
);

create table hm_blocked_attachments
(
	baid bigint auto_increment not null, primary key(baid), unique(baid),
	bawildcard varchar(255) not null,
	badescription varchar(255) not null
);

create table hm_servermessages
(
	smid int auto_increment not null, primary key(smid), unique(smid), 
	smname varchar(255) not null,
	smtext text not null
);

create table hm_tcpipports
(
	portid bigint auto_increment not null, primary key(portid), unique(portid),
	portprotocol tinyint not null,
	portnumber int not null
);

create table hm_whitelist
(
	whiteid bigint auto_increment not null, primary key(whiteid), unique(whiteid),
	whiteloweripaddress bigint not null,
	whiteupperipaddress bigint not null,
	whiteemailaddress varchar(255) not null,
	whitedescription varchar(255) not null
);

insert into hm_servermessages (smname, smtext) values ('VIRUS_FOUND', 'Virus found');
insert into hm_servermessages (smname, smtext) values ('VIRUS_NOTIFICATION', 'The message below contained a virus and did not\r\nreach some or all of the intended recipients.\r\n\r\n   From: %MACRO_FROM%\r\n   To: %MACRO_TO%\r\n   Sent: %MACRO_SENT%\r\n   Subject: %MACRO_SUBJECT%\r\n\r\nhMailServer\r\n');
insert into hm_servermessages (smname, smtext) values ('SEND_FAILED_NOTIFICATION', 'Your message did not reach some or all of the intended recipients.\r\n\r\n   Sent: %MACRO_SENT%\r\n   Subject: %MACRO_SUBJECT%\r\n\r\nThe following recipient(s) could not be reached:\r\n\r\n%MACRO_RECIPIENTS%\r\n\r\nhMailServer\r\n');
insert into hm_servermessages (smname, smtext) values ('MESSAGE_UNDELIVERABLE', 'Message undeliverable');
insert into hm_servermessages (smname, smtext) values ('MESSAGE_FILE_MISSING', 'The mail server could not deliver the message to you since the file %MACRO_FILE% does not exist on the server.\r\n\r\nThe file may have been deleted by anti virus software running on the server.\r\n\r\nhMailServer');
insert into hm_servermessages (smname, smtext) values ('ATTACHMENT_REMOVED', 'The attachment %MACRO_FILE% was blocked for delivery by the e-mail server. Please contact your system administrator if you have any questions regarding this.\r\n\r\nhMailServer\r\n');

insert into hm_dnsbl (sblactive, sbldnshost, sblresult, sblrejectmessage) values (0, 'zen.spamhaus.org','127.0.0.*', 'Rejected by Spamhaus');
insert into hm_dnsbl (sblactive, sbldnshost, sblresult, sblrejectmessage) values (0, 'bl.spamcop.net', '127.0.0.*','Rejected by SpamCop');

insert into hm_surblservers (surblactive, surblhost, surblrejectmessage) values (0, 'multi.surbl.org', 'Rejected by SURBL');

insert into hm_blocked_attachments (bawildcard, badescription) values ('*.bat', 'Batch processing file');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.cmd', 'Command file for Windows NT');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.com', 'Command');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.cpl', 'Windows Control Panel extension');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.csh', 'CSH script');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.exe', 'Executable file');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.inf', 'Setup file');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.lnk', 'Windows link file');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.msi', 'Windows Installer file');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.msp', 'Windows Installer patch');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.reg', 'Registration key');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.scf', 'Windows Explorer command');
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.scr', 'Windows Screen saver');

insert into hm_settings (settingname, settingstring, settinginteger) values ('maxpop3connections', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxsmtpconnections', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('mirroremailaddress', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('relaymode', '', 2);
insert into hm_settings (settingname, settingstring, settinginteger) values ('authallowplaintext', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('allowmailfromnull', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('logging', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('logdevice', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('tarpitdelay', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('tarpitcount', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpnoofretries', '', 4);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpminutesbetweenretries', '', 60);
insert into hm_settings (settingname, settingstring, settinginteger) values ('protocolimap', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('protocolsmtp', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('protocolpop3', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('welcomeimap', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('welcomepop3', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('welcomesmtp', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayer', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxdelivertythreads', '', 3);
insert into hm_settings (settingname, settingstring, settinginteger) values ('logformat', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avclamwinenable', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avclamwinexec', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avclamwindb', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avnotifysender', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avnotifyreceiver', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avaction', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('sendstatistics', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('hostname', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayerusername', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayerpassword', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usesmtprelayerauthentication', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayerport', '', 25);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usedeliverylog', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usecustomvirusscanner', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('customvirusscannerexecutable', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('customviursscannerreturnvalue', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usespf', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usemxchecks', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usescriptserver', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('scriptlanguage', 'VBScript', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxmessagesize', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('listenonalladdresses', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usecache', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('domaincachettl', '', 60);
insert into hm_settings (settingname, settingstring, settinginteger) values ('accountcachettl', '', 60);
insert into hm_settings (settingname, settingstring, settinginteger) values ('awstatsenabled', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('rulelooplimit', '', 5);
insert into hm_settings (settingname, settingstring, settinginteger) values ('backupoptions', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('backupdestination', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('defaultdomain', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('avmaxmsgsize', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpdeliverybindtoip', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('spamaction', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableimapquota', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableimapidle', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maximapconnections', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableimapsort', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maskpasswordsinlog', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('workerthreadpriority', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('ascheckhostinhelo', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('tcpipthreads', '', 15);
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpallowincorrectlineendings', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('usegreylisting', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('greylistinginitialdelay', '', 30);
insert into hm_settings (settingname, settingstring, settinginteger) values ('greylistinginitialdelete', '', 24);
insert into hm_settings (settingname, settingstring, settinginteger) values ('greylistingfinaldelete', '', 864);
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamaddheaderspam', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamaddheaderreason', '', 1);
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamprependsubject', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamprependsubjecttext', '[SPAM]', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableattachmentblocking', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxsmtprecipientsinbatch', '', 100);
insert into hm_settings (settingname, settingstring, settinginteger) values ('disconnectinvalidclients', '', 0);
insert into hm_settings (settingname, settingstring, settinginteger) values ('maximumincorrectcommands', '', 100);
insert into hm_settings (settingname, settingstring, settinginteger) values ('aliascachettl', '', 60);
insert into hm_settings (settingname, settingstring, settinginteger) values ('distributionlistcachettl', '', 60);

insert into hm_tcpipports (portprotocol, portnumber) values (1, 25);
insert into hm_tcpipports (portprotocol, portnumber) values (3, 110);
insert into hm_tcpipports (portprotocol, portnumber) values (5, 143);

insert into hm_dbversion values (4402);
