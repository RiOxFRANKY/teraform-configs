$builds = @(
    @{ Path = "Coppermine photo gallery"; Tag = "coppermine-local:1.4.11" },
    @{ Path = "Filerun"; Tag = "filerun-local:2021.03.26" },
    @{ Path = "Mailcow"; Tag = "mailcow-local:0.14" },
    @{ Path = "Mailhog"; Tag = "mailhog-local:1.0.1" },
    @{ Path = "Piwigo"; Tag = "piwigo-local:2.5.3" },
    @{ Path = "Seafile"; Tag = "seafile-local:3.1.4" },
    @{ Path = "Zenphoto"; Tag = "zenphoto-local:1.4.3.3" },
    @{ Path = "hmailserver"; Tag = "hmailserver-webadmin:4.4.2" },
    @{ Path = "nginx"; Tag = "ingress-nginx-local:4.11.0" }
)

foreach ($build in $builds) {
    Write-Host "--- Building $($build.Tag) from $($build.Path) ---" -ForegroundColor Cyan
    if (Test-Path "$($build.Path)\Dockerfile") {
        docker build -t $($build.Tag) "$($build.Path)"
        if ($LASTEXITCODE -ne 0) {
            Write-Error "Build failed for $($build.Tag)"
        }
    } else {
        Write-Warning "No Dockerfile found in $($build.Path)"
    }
}
