<? $user = Rakuun_User_Manager::getCurrentUser(); ?>
<?= Rakuun_Intern_Production_Influences::getPeopleSatisfactionText($user); ?>
<br class="clear" />
<? if ($this->hasPanel('picture')): ?>
	<? $this->displayPanel('picture'); ?>
<? endif; ?>
<br class="clear" />
Username: 
<? $userlink = new Rakuun_GUI_Control_UserLink('userlink', $user); ?>
<? $userlink->display(); ?>
<br class="clear" />
Stadtname: <?= Text::escapeHTML($user->cityName); ?>
<br class="clear" />
Punkte: <?= GUI_Panel_Number::formatNumber((int)$user->points); ?>
<? if ($user->alliance) : ?>
	<br class="clear" />
	Allianz:
	<? $allylink = new Rakuun_GUI_Control_AllianceLink('allylink', $user->alliance, $user->alliance->name); ?>
	<? $allylink->display(); ?>
<? endif;?>
<br class="clear" />
Koordinaten:
<? $mapLink = new Rakuun_GUI_Control_Maplink('maplink', $user, 'zur Karte'); ?>
<? $mapLink->display(); ?>
<br class="clear" />
<? if($user->isInNoob()): ?>
<br class="clear" />
	Hinweis: Du befindest dich im Noobschutz!
	Im Noobschutz kannst du nicht handeln und nicht angegriffen werden.
	Du verlässt den Noobschutz, sobald deine Punktzahl 
	<? $averagePoints = Rakuun_Intern_Statistics::averagePoints(); ?>
	<? $output = '>= '; ?>
	<? if ($averagePoints > RAKUUN_NOOB_START_LIMIT_OF_POINTS): ?>
		<? $output .= $averagePoints; ?>
	<? else: ?>
		<? $output .= RAKUUN_NOOB_START_LIMIT_OF_POINTS; ?>
	<? endif; ?> 
	<?= $output; ?>
	oder deine Armeestärke
	<? $averagePoints = Rakuun_Intern_Statistics::averageArmyStrength(); ?>
	<? $output = '>= '; ?>
	<? if ($averagePoints > RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH): ?>
		<? $output .= $averagePoints; ?>
	<? else: ?>
		<? $output .= RAKUUN_NOOB_START_LIMIT_OF_ARMY_STRENGTH; ?>
	<? endif; ?>
	<?= $output; ?> ist oder du ein Datenbankteil eroberst oder ein Schildgenerator baust. 
<? endif; ?>