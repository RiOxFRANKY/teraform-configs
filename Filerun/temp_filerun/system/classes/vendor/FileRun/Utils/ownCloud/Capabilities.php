<?php
namespace FileRun\Utils\ownCloud;


class Capabilities {
	static function serve() {
		global $settings, $config;
		$mainColor = self::getCurrentThemeColor();
		$rs = [
			"ocs" => [
				"meta" => [
					"status" => 'ok',
					"statuscode" => 100,
					"message" => 'OK',
					'itemsperpage' => '',
					'totalitems' => ''
				],
				"data" => [
					'version' => [
						'major' => 20,
						'minor' => 0,
						'micro' => 0,
						'string' => "20.0.0",
						'edition' => ''
					],
					'capabilities' => [
						'core' => [
							'pollinterval' => 60,
							'webdav-root' => 'remote.php/webdav'
						],
						'dav' => [
							'chunking' => '1.0'
						],
						'files_sharing' => [
							'api_enabled' => true,
							'group_sharing' => false,
							'resharing' => false,
							'sharebymail' => ['enabled' => false],
							'user' => ['send_mail' => false],
							'public' => ['enabled' => true]
						],
						'ocm' => [
							'apiVersion' => "1.0-proposal1",
							'enabled' => true,
							'endPoint' => gluePath(\FM::dirname($config['url']['root']), '/index.php/ocm')
						],
						'theming' => [
							'name' => $settings->app_title,
							'slogan' => 'Self-Hosted File Sync and Sharing',
							'url' => 'https://filerun.com',
							'color' => $mainColor,
							'color-element' => '#aaaaaa',
							'color-text' => '#FFFFFF',
							'logo' =>  $settings->ui_logo_url ?: false,
							'background' => $settings->ui_login_bg ?: $mainColor,
							'background-default' => !$settings->ui_login_bg,
							'background-plain' => !$settings->ui_login_bg
						],
						'files' => [
							'bigfilechunking' => true,
							'undelete' => false,
							'versioning' => false
						]/*,
						'notifications' => [
							'ocs-endpoints' => []
						]*/
					]
				]
			]
		];

		$blockedTypes = $settings->upload_blocked_types;
		if (strlen($blockedTypes) > 0) {
			$blockedTypes = explode(',', strtolower($blockedTypes));
			$blockedTypes = array_map('trim', $blockedTypes);
			$rs['capabilities']['files']['blacklisted_files'] = $blockedTypes;
		}

		jsonOutput($rs);
	}

	public static function getCurrentThemeColor() {
		global $settings;
		$themeName = $settings->ui_theme;
		if ($themeName == 'red') {return '#C0392B';}
		if ($themeName == 'green') {return '#0F9D58';}
		if ($themeName == 'dark') {return '#303030';}
		//default is blue
		return '#4285F4';
	}
}