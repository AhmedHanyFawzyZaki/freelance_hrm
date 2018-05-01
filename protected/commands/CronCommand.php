<?php

class CronCommand extends CConsoleCommand {
    public function run($args) {
        // here we are doing what we need to do
		$users=User::model()->findAll();
		foreach($users as $user)
		{
			$user->today_follows=0;
			$user->today_points=0;
			$user->password=$user->simple_decrypt($user->password);
			$user->save(false);
		}
    }
}

?>