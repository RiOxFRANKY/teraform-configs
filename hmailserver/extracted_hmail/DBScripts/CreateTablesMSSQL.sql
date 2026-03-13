if exists (select * from sysobjects where id = object_id('hm_accounts') and objectproperty(id, 'isusertable') = 1) drop table hm_accounts ---
if exists (select * from sysobjects where id = object_id('hm_imapfolders') and objectproperty(id, 'isusertable') = 1) drop table hm_imapfolders ---
if exists (select * from sysobjects where id = object_id('hm_securityranges') and objectproperty(id, 'isusertable') = 1) drop table hm_securityranges ---
if exists (select * from sysobjects where id = object_id('hm_aliases') and objectproperty(id, 'isusertable') = 1) drop table hm_aliases ---
if exists (select * from sysobjects where id = object_id('hm_accounts') and objectproperty(id, 'isusertable') = 1) drop table hm_accounts ---
if exists (select * from sysobjects where id = object_id('hm_domains') and objectproperty(id, 'isusertable') = 1) drop table hm_domains ---
if exists (select * from sysobjects where id = object_id('hm_domain_aliases') and objectproperty(id, 'isusertable') = 1) drop table hm_domain_aliases ---
if exists (select * from sysobjects where id = object_id('hm_messages') and objectproperty(id, 'isusertable') = 1) drop table hm_messages ---
if exists (select * from sysobjects where id = object_id('hm_settings') and objectproperty(id, 'isusertable') = 1) drop table hm_settings ---
if exists (select * from sysobjects where id = object_id('hm_dbversion') and objectproperty(id, 'isusertable') = 1) drop table hm_dbversion ---
if exists (select * from sysobjects where id = object_id('hm_routes') and objectproperty(id, 'isusertable') = 1) drop table hm_routes ---
if exists (select * from sysobjects where id = object_id('hm_routeaddresses') and objectproperty(id, 'isusertable') = 1) drop table hm_routeaddresses ---
if exists (select * from sysobjects where id = object_id('hm_serverlog') and objectproperty(id, 'isusertable') = 1) drop table hm_serverlog ---
if exists (select * from sysobjects where id = object_id('hm_distributionlists') and objectproperty(id, 'isusertable') = 1) drop table hm_distributionlists ---
if exists (select * from sysobjects where id = object_id('hm_distributionlistsrecipients') and objectproperty(id, 'isusertable') = 1) drop table hm_distributionlistsrecipients ---
if exists (select * from sysobjects where id = object_id('hm_messagerecipients') and objectproperty(id, 'isusertable') = 1) drop table hm_messagerecipients ---
if exists (select * from sysobjects where id = object_id('hm_deliverylog') and objectproperty(id, 'isusertable') = 1) drop table hm_deliverylog ---
if exists (select * from sysobjects where id = object_id('hm_deliverylog_recipients') and objectproperty(id, 'isusertable') = 1) drop table hm_deliverylog_recipients ---
if exists (select * from sysobjects where id = object_id('hm_dnsbl') and objectproperty(id, 'isusertable') = 1) drop table hm_dnsbl ---
if exists (select * from sysobjects where id = object_id('hm_fetchaccounts') and objectproperty(id, 'isusertable') = 1) drop table hm_fetchaccounts ---
if exists (select * from sysobjects where id = object_id('hm_fetchaccounts_uids') and objectproperty(id, 'isusertable') = 1) drop table hm_fetchaccounts_uids ---
if exists (select * from sysobjects where id = object_id('hm_rules') and objectproperty(id, 'isusertable') = 1) drop table hm_rules ---
if exists (select * from sysobjects where id = object_id('hm_rule_criterias') and objectproperty(id, 'isusertable') = 1) drop table hm_rule_criterias ---
if exists (select * from sysobjects where id = object_id('hm_rule_actions') and objectproperty(id, 'isusertable') = 1) drop table hm_rule_actions ---
if exists (select * from sysobjects where id = object_id('hm_iphomes') and objectproperty(id, 'isusertable') = 1) drop table hm_iphomes ---
if exists (select * from sysobjects where id = object_id('hm_surblservers') and objectproperty(id, 'isusertable') = 1) drop table hm_surblservers ---
if exists (select * from sysobjects where id = object_id('hm_greylisting_triplets') and objectproperty(id, 'isusertable') = 1) drop table hm_greylisting_triplets ---
if exists (select * from sysobjects where id = object_id('hm_blocked_attachments') and objectproperty(id, 'isusertable') = 1) drop table hm_blocked_attachments ---
if exists (select * from sysobjects where id = object_id('hm_servermessages') and objectproperty(id, 'isusertable') = 1) drop table hm_servermessages ---
if exists (select * from sysobjects where id = object_id('hm_adsynchronization') and objectproperty(id, 'isusertable') = 1) drop table hm_adsynchronization ---
if exists (select * from sysobjects where id = object_id('hm_greylisting_whiteaddresses') and objectproperty(id, 'isusertable') = 1) drop table hm_greylisting_whiteaddresses ---
if exists (select * from sysobjects where id = object_id('hm_tcpipports') and objectproperty(id, 'isusertable') = 1) drop table hm_tcpipports ---
if exists (select * from sysobjects where id = object_id('hm_whitelist') and objectproperty(id, 'isusertable') = 1) drop table hm_whitelist ---



create table hm_accounts (
	accountid int identity (1, 1) not null CONSTRAINT hm_accounts_pk PRIMARY KEY NONCLUSTERED,
	accountdomainid int not null ,
	accountadminlevel tinyint not null ,
	accountaddress varchar (255) not null , CONSTRAINT u_accountaddress UNIQUE NONCLUSTERED (accountaddress),
	accountpassword varchar (255) not null ,
	accountactive int not null, 
	accountisad int not null, 
	accountaddomain varchar (255) not null ,
	accountadusername varchar (255) not null,
	accountmaxsize int not null default 0,
	accountvacationmessageon tinyint not null default 0,
	accountvacationmessage varchar (1000) not null default '',
	accountvacationsubject varchar (200) not null default '',
	accountpwencryption tinyint not null,
	accountforwardenabled tinyint not null,
	accountforwardaddress varchar (255) not null,
	accountforwardkeeporiginal tinyint not null,
	accountenablesignature tinyint not null,
	accountsignatureplaintext text not null,
	accountsignaturehtml text not null,
	accountlastlogontime datetime not null,
	accountvacationexpires tinyint not null,
	accountvacationexpiredate datetime not null
) ---

CREATE CLUSTERED INDEX idx_hm_accounts ON hm_accounts (accountaddress) ---

create table hm_aliases (
	aliasid int identity (1, 1) not null CONSTRAINT hm_aliases_pk PRIMARY KEY NONCLUSTERED,
	aliasdomainid int not null ,
	aliasname varchar (255) not null , CONSTRAINT u_aliasname UNIQUE NONCLUSTERED (aliasname),
	aliasvalue varchar (255) not null ,	
	aliasactive tinyint not null,
	aliastype tinyint not null
) ---

CREATE CLUSTERED INDEX idx_hm_aliases ON hm_aliases (aliasdomainid, aliasname)  ---

create table hm_domains (
	domainid int identity (1, 1) not null CONSTRAINT hm_domains_pk PRIMARY KEY NONCLUSTERED,
	domainname varchar (80) not null, CONSTRAINT u_domainname UNIQUE NONCLUSTERED (domainname),
	domainactive tinyint not null,
	domainpostmaster varchar (80) not null,
	domainmaxsize int not null,
	domainaddomain varchar(255) not null,
	domainmaxmessagesize int not null,
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
) ---

CREATE CLUSTERED INDEX idx_hm_domains ON hm_domains (domainname)  ---

create table hm_domain_aliases (
	daid int identity (1, 1) not null CONSTRAINT hm_domain_aliases_pk PRIMARY KEY NONCLUSTERED,
	dadomainid integer not null ,
	daalias varchar(255) not null
) ---

create table hm_messages (
	messageid bigint identity (1, 1) not null CONSTRAINT hm_messages_pk PRIMARY KEY NONCLUSTERED,
	messageaccountid int not null ,
	messagefolderid int not null ,
	messagefilename varchar (255) not null ,
	messagetype tinyint not null ,
	messagefrom varchar (255) not null ,
	messagerecipients varchar (500) not null ,
	messagesize bigint not null,
	messagecurnooftries int not null DEFAULT 0,
	messagenexttrytime datetime not null DEFAULT GETDATE(),
	messageflagseen tinyint not null,
	messageflagdeleted tinyint not null,
	messageflagrecent tinyint not null,
	messageflaganswered tinyint not null,
	messageflagflagged tinyint not null,
	messageflagdraft tinyint not null,	
	messagerecipientsparsed tinyint not null,
	messagecreatetime datetime not null DEFAULT GETDATE(),
	messagelocked tinyint not null
) ---

CREATE CLUSTERED INDEX idx_hm_messages ON hm_messages (messageaccountid, messagefolderid)  ---

CREATE INDEX idx_hm_messages_type ON hm_messages (messagetype) ---

create table hm_settings (
	settingid int identity (1, 1) not null CONSTRAINT hm_settings_pk PRIMARY KEY NONCLUSTERED,
	settingname varchar (30) not null , CONSTRAINT u_settingname UNIQUE NONCLUSTERED (settingname),
	settingstring varchar (255) not null ,
	settinginteger int not null
) ---

create table hm_dbversion (
	value int not null
) ---

create table hm_serverlog (
	logid int identity (1, 1) not null CONSTRAINT hm_serverlog_pk PRIMARY KEY NONCLUSTERED,
	logprocessid int not null,
	logthreadid int not null,	
	logsource int not null,
	logtime datetime not null,
	logremotehost varchar(15) not null,
	logtext varchar(600)
) ---

create table hm_distributionlists 
(
	distributionlistid int identity (1, 1) not null CONSTRAINT hm_distributionlists_pk PRIMARY KEY NONCLUSTERED,
	distributionlistdomainid int not null,
	distributionlistaddress varchar(255) not null, CONSTRAINT u_distributionlistaddress UNIQUE NONCLUSTERED (distributionlistaddress),
	distributionlistenabled tinyint not null,	
   distributionlistrequireauth tinyint not null,
	distributionlistrequireaddress varchar(255) not null,
	distributionlistmode tinyint not null
) ---

CREATE CLUSTERED INDEX idx_hm_distributionlists_distributionlistdomainid ON hm_distributionlists (distributionlistdomainid) ---

create table hm_distributionlistsrecipients
(
	distributionlistrecipientid int identity (1, 1) not null CONSTRAINT hm_distributionlistsrecipients_pk PRIMARY KEY NONCLUSTERED,
	distributionlistrecipientlistid int not null,
	distributionlistrecipientaddress varchar(255)	
) ---

CREATE CLUSTERED INDEX idx_hm_distributionlistsrecipients_distributionlistrecipientlistid ON hm_distributionlistsrecipients (distributionlistrecipientlistid)  ---

create table hm_messagerecipients
(
	recipientid bigint identity (1, 1) not null CONSTRAINT hm_messagerecipients_pk PRIMARY KEY NONCLUSTERED,
   recipientmessageid bigint not null,
	recipientaddress varchar(255) not null,
	recipientislocal tinyint not null,
	recipientisenabled tinyint not null,
	recipientisexisting tinyint not null,
	recipientlocalaccountid int not null
) ---

CREATE CLUSTERED INDEX idx_hm_messagerecipients_recipientmessageid ON hm_messagerecipients (recipientmessageid) ---

create table hm_imapfolders 
(
	folderid int identity (1, 1) not null CONSTRAINT hm_imapfolders_pk PRIMARY KEY NONCLUSTERED,
	folderaccountid int NOT NULL,
	folderparentid int NOT NULL,
	foldername varchar(255) NOT NULL,
	folderissubscribed tinyint NOT NULL
) ---

CREATE CLUSTERED INDEX idx_hm_imapfolders_folderaccountid ON hm_imapfolders (folderaccountid)  ---

create table hm_securityranges
(
	rangeid int identity (1, 1) not null CONSTRAINT hm_securityranges_pk PRIMARY KEY NONCLUSTERED,
  	rangepriorityid int not null,
	rangelowerip bigint not null,
	rangeupperip bigint not null,
	rangeoptions int not null,
	rangename varchar (100) not null, CONSTRAINT u_rangename UNIQUE NONCLUSTERED (rangename)
) ---

insert into hm_securityranges (rangepriorityid, rangelowerip, rangeupperip, rangeoptions, rangename) values (10, 0, 4294967295, 1515, 'Internet') ---
insert into hm_securityranges (rangepriorityid, rangelowerip, rangeupperip, rangeoptions, rangename) values (15, 2130706433, 2130706433, 1483, 'My computer') ---

create table hm_routes 
(
  routeid int identity (1, 1) not null CONSTRAINT hm_routes_pk PRIMARY KEY NONCLUSTERED,
  routedomainname varchar(255) NOT NULL, CONSTRAINT u_routedomainname UNIQUE NONCLUSTERED (routedomainname),
  routetargetsmthost varchar(255) NOT NULL,
  routetargetsmtport int NOT NULL,
  routenooftries int NOT NULL,
  routeminutesbetweentry int NOT NULL,
  routealladdresses tinyint NOT NULL,
  routeuseauthentication tinyint NOT NULL,
  routeauthenticationusername varchar(255) NOT NULL,
  routeauthenticationpassword varchar(255) NOT NULL,
  routetreatsecurityaslocal tinyint NOT NULL 
) ---

create table hm_routeaddresses
(
  routeaddressid int identity (1, 1) not null CONSTRAINT hm_routeaddresses_pk PRIMARY KEY NONCLUSTERED,
  routeaddressrouteid int NOT NULL,
  routeaddressaddress varchar(255) NOT NULL
) ---

create table hm_deliverylog
(
	deliveryid int identity (1, 1) not null CONSTRAINT hm_deliverylog_pk PRIMARY KEY NONCLUSTERED,
	deliveryfrom varchar(255) not null,
   deliveryfilename varchar(255) not null,
   deliverytime datetime not null,
	deliverysubject varchar(255) not null,
	deliverybody varchar(7000) not null
) ---

create table hm_deliverylog_recipients
(
	deliveryrecipientid int identity (1, 1) not null CONSTRAINT hm_deliverylog_recipients_pk PRIMARY KEY NONCLUSTERED,
   deliveryid int not null,
	deliveryrecipientaddress varchar(255) not null
) ---

create table hm_dnsbl
(
	sblid int identity (1, 1) not null CONSTRAINT hm_dnsbl_pk PRIMARY KEY NONCLUSTERED,
   sblactive int not null,
   sbldnshost varchar(255) not null,
   sblresult varchar(255) not null,
   sblrejectmessage varchar(255) not null
) ---

create table hm_fetchaccounts
(	
	faid int identity(1,1) not null CONSTRAINT hm_fetchaccounts_pk PRIMARY KEY NONCLUSTERED,
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
) ---

create table hm_fetchaccounts_uids
(
	uidid int identity(1,1) not null CONSTRAINT hm_fetchaccounts_uids_pk PRIMARY KEY NONCLUSTERED,
	uidfaid int not null,
	uidvalue varchar(255) not null,
	uidtime datetime not null
) ---

CREATE CLUSTERED INDEX idx_hm_fetchaccounts_uids ON hm_fetchaccounts_uids (uidfaid)  ---

create table hm_rules
(
	ruleid int identity(1,1) not null CONSTRAINT hm_rules_pk PRIMARY KEY NONCLUSTERED,
	ruleaccountid int not null,
	rulename varchar(100) not null,
	ruleactive tinyint not null,
	ruleuseand tinyint not null,
	rulesortorder int not null
) ---

CREATE CLUSTERED INDEX idx_hm_rules ON hm_rules (ruleaccountid)  ---

create table hm_rule_criterias
(
	criteriaid int identity(1,1) not null CONSTRAINT hm_rule_criterias_pk PRIMARY KEY NONCLUSTERED,
	criteriaruleid int not null,
	criteriausepredefined tinyint not null,
	criteriapredefinedfield tinyint not null,
	criteriaheadername varchar(255) not null,
	criteriamatchtype tinyint not null,
	criteriamatchvalue varchar(255) not null
	
) ---

CREATE CLUSTERED INDEX idx_hm_rule_criterias ON hm_rule_criterias (criteriaruleid)  ---

create table hm_rule_actions
(
	actionid int identity(1,1) not null CONSTRAINT hm_rule_actions_pk PRIMARY KEY NONCLUSTERED,
	actionruleid int not null,
	actiontype tinyint not null,
	actionimapfolder varchar(255) not null,
	actionsubject varchar(255) not null,
	actionfromname varchar(255) not null,
	actionfromaddress varchar(255) not null,
	actionto varchar(255) not null,
	actionbody varchar(5000) not null,
	actionfilename varchar(255) not null,
	actionsortorder int not null,
	actionscriptfunction varchar(255) not null,
	actionrouteid int not null
) ---

CREATE CLUSTERED INDEX idx_hm_rule_actions ON hm_rule_actions (actionruleid) ---

create table hm_adsynchronization
(
	synchid int identity(1,1) not null CONSTRAINT hm_adsynchronization_pk PRIMARY KEY NONCLUSTERED,
	synchaccountid int not null,
	synchguid varchar(50) not null
) ---

create table hm_iphomes
(
	iphomeid int identity(1,1) not null CONSTRAINT hm_iphomes_pk PRIMARY KEY NONCLUSTERED,
	iphomeaddress bigint  not null
) ---

create table hm_surblservers
(
	surblid int identity(1,1) not null CONSTRAINT hm_surblid_pk PRIMARY KEY NONCLUSTERED,
	surblactive tinyint not null,
	surblhost varchar(255) not null,
	surblrejectmessage varchar(255) not null
) ---

create table hm_greylisting_triplets
(
	glid bigint identity(1,1) not null CONSTRAINT hm_glid_pk PRIMARY KEY NONCLUSTERED,
	glcreatetime datetime not null,
	glblockendtime datetime not null,
	gldeletetime datetime not null,
	glipaddress bigint not null,
	glsenderaddress varchar(255) not null,
	glrecipientaddress varchar(255) not null,
	glblockedcount int not null,
	glpassedcount int not null
	CONSTRAINT u_gltriplet UNIQUE NONCLUSTERED (glipaddress, glsenderaddress, glrecipientaddress)
) ---

create table hm_greylisting_whiteaddresses
(
	whiteid bigint identity(1,1) not null CONSTRAINT hm_glwhite_pk PRIMARY KEY NONCLUSTERED,
	whiteipaddress varchar(255) not null,
	whiteipdescription varchar(255) not null
	CONSTRAINT u_glwhite UNIQUE NONCLUSTERED (whiteipaddress)
) ---

create table hm_blocked_attachments
(
	baid bigint identity(1,1) not null CONSTRAINT hm_baid_pk PRIMARY KEY NONCLUSTERED,
	bawildcard varchar(255) not null,
	badescription varchar(255) not null
) ---

create table hm_servermessages
(
	smid int identity(1,1) not null CONSTRAINT hm_smid_pk PRIMARY KEY NONCLUSTERED, 
	smname varchar(255) not null,
	smtext text not null
) ---

create table hm_tcpipports
(
	portid int identity(1,1) not null CONSTRAINT hm_tcpipports_pk PRIMARY KEY NONCLUSTERED, 
	portprotocol tinyint not null,
	portnumber int not null
) ---

create table hm_whitelist
(
	whiteid bigint identity(1,1) not null CONSTRAINT hm_whitelist_pk PRIMARY KEY NONCLUSTERED,
	whiteloweripaddress bigint not null,
	whiteupperipaddress bigint not null,
	whiteemailaddress varchar(255) not null,
	whitedescription varchar(255) not null
) ---


insert into hm_servermessages (smname, smtext) values ('VIRUS_FOUND', 'Virus found') --- 
insert into hm_servermessages (smname, smtext) values ('VIRUS_NOTIFICATION', 'The message below contained a virus and did not' + CHAR(13) + CHAR(10) + 'reach some or all of the intended recipients.' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + '   From: %MACRO_FROM%' + CHAR(13) + CHAR(10) + '   To: %MACRO_TO%' + CHAR(13) + CHAR(10) + '   Sent: %MACRO_SENT%' + CHAR(13) + CHAR(10) + '   Subject: %MACRO_SUBJECT%' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + 'hMailServer' + CHAR(13) + CHAR(10) + '') --- 
insert into hm_servermessages (smname, smtext) values ('SEND_FAILED_NOTIFICATION', 'Your message did not reach some or all of the intended recipients.' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + '   Sent: %MACRO_SENT%' + CHAR(13) + CHAR(10) + '   Subject: %MACRO_SUBJECT%' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + 'The following recipient(s) could not be reached:' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + '%MACRO_RECIPIENTS%' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + 'hMailServer' + CHAR(13) + CHAR(10) + '') --- 
insert into hm_servermessages (smname, smtext) values ('MESSAGE_UNDELIVERABLE', 'Message undeliverable') --- 
insert into hm_servermessages (smname, smtext) values ('MESSAGE_FILE_MISSING', 'The mail server could not deliver the message to you since the file %MACRO_FILE% does not exist on the server.' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + 'The file may have been deleted by anti virus software running on the server.' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + 'hMailServer') --- 
insert into hm_servermessages (smname, smtext) values ('ATTACHMENT_REMOVED', 'The attachment %MACRO_FILE% was blocked for delivery by the e-mail server. Please contact your system administrator if you have any questions regarding this.' + CHAR(13) + CHAR(10) + '' + CHAR(13) + CHAR(10) + 'hMailServer' + CHAR(13) + CHAR(10) + '') --- 

insert into hm_dnsbl (sblactive, sbldnshost, sblresult, sblrejectmessage) values (0, 'zen.spamhaus.org', '127.0.0.*', 'Rejected by Spamhaus') ---
insert into hm_dnsbl (sblactive, sbldnshost, sblresult, sblrejectmessage) values (0, 'bl.spamcop.net', '127.0.0.*', 'Rejected by SpamCop') ---


insert into hm_surblservers (surblactive, surblhost, surblrejectmessage) values (0, 'multi.surbl.org', 'Rejected by SURBL') ---

insert into hm_blocked_attachments (bawildcard, badescription) values ('*.bat', 'Batch processing file') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.cmd', 'Command file for Windows NT') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.com', 'Command') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.cpl', 'Windows Control Panel extension') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.csh', 'CSH script') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.exe', 'Executable file') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.inf', 'Setup file') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.lnk', 'Windows link file') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.msi', 'Windows Installer file') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.msp', 'Windows Installer patch') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.reg', 'Registration key') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.scf', 'Windows Explorer command') ---
insert into hm_blocked_attachments (bawildcard, badescription) values ('*.scr', 'Windows Screen saver') ---


insert into hm_settings (settingname, settingstring, settinginteger) values ('maxpop3connections', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxsmtpconnections', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('mirroremailaddress', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('relaymode', '', 2) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('authallowplaintext', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('allowmailfromnull', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('logging', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('logdevice', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('tarpitdelay', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('tarpitcount', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpnoofretries', '', 4) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpminutesbetweenretries', '', 60) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpnooftries', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('protocolimap', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('protocolsmtp', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('protocolpop3', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('welcomeimap', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('welcomepop3', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('welcomesmtp', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayer', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxdelivertythreads', '', 3) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('logformat', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avclamwinenable', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avclamwinexec', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avclamwindb', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avnotifysender', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avnotifyreceiver', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avaction', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('sendstatistics', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('hostname', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayerusername', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayerpassword', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usesmtprelayerauthentication', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtprelayerport', '', 25) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usedeliverylog', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usecustomvirusscanner', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('customvirusscannerexecutable', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('customviursscannerreturnvalue', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usespf', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usemxchecks', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usescriptserver', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('scriptlanguage', 'VBScript', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxmessagesize', '', 0)  ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('listenonalladdresses', '', 1)  ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usecache', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('domaincachettl', '', 60)  ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('accountcachettl', '', 60) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('awstatsenabled', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('rulelooplimit', '', 5) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('backupoptions', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('backupdestination', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('defaultdomain', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('avmaxmsgsize', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpdeliverybindtoip', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('spamaction', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableimapquota', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableimapidle', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maximapconnections', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableimapsort', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maskpasswordsinlog', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('workerthreadpriority', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('ascheckhostinhelo', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('tcpipthreads', '', 15) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('smtpallowincorrectlineendings', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('usegreylisting', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('greylistinginitialdelay', '', 30) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('greylistinginitialdelete', '', 24) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('greylistingfinaldelete', '', 864) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamaddheaderspam', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamaddheaderreason', '', 1) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamprependsubject', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('antispamprependsubjecttext', '[SPAM]', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('enableattachmentblocking', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maxsmtprecipientsinbatch', '', 100) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('disconnectinvalidclients', '', 0) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('maximumincorrectcommands', '', 100) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('aliascachettl', '', 60) ---
insert into hm_settings (settingname, settingstring, settinginteger) values ('distributionlistcachettl', '', 60) ---

insert into hm_tcpipports (portprotocol, portnumber) values (1, 25) ---
insert into hm_tcpipports (portprotocol, portnumber) values (3, 110) ---
insert into hm_tcpipports (portprotocol, portnumber) values (5, 143) ---


insert into hm_dbversion values (4402) ---


