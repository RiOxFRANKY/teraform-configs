' This small scripts starts an hMailServer backup
' using the settings specified in hMailAdmin.

Const sAdminPassword = "<ADMINISTRATORPASSWORD>"

Dim oApp
Set oApp = CreateObject("hMailServer.Application")

' Authenticate the client.
Call oApp.Authenticate ("Administrator", sAdminPassword)

Call oApp.BackupManager.StartBackup()