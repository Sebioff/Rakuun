<? $satisfactionBonus = (Rakuun_Intern_Production_Influences::getPeopleSatisfactionRate() * 100) - 100; ?>
<? $satisfactionBonus = ($satisfactionBonus > 0) ? '+'.$satisfactionBonus : $satisfactionBonus ?>
<?= Rakuun_Intern_Production_Influences::getPeopleSatisfactionText() ?>
<? if ($satisfactionBonus != 0): ?>
 - Ressourcenproduktion <?= $satisfactionBonus ?>%
<? endif; ?>
<br/>
<? $ressourceProductionDatabase = new Rakuun_User_Specials_Database(Rakuun_User_Manager::getCurrentUser(), Rakuun_User_Specials::SPECIAL_DATABASE_BROWN); ?>
<? if ($ressourceProductionDatabase->hasSpecial()): ?>
	<? $effectValues = Rakuun_User_Specials::getEffectValues(); ?>
	<?= 'Produktionsrate von Eisen und Beryllium durch Ressourcenproduktions-Datenbankteil um '.($effectValues[Rakuun_User_Specials::SPECIAL_DATABASE_BROWN] * 100).'% erhöht';?>
	<br/>
<? endif; ?>
<br/>
<? $this->displayPanel('ressource_production'); ?>
<br class="clear" />
<? $this->displayPanel('ressource_capacity'); ?>
<br class="clear" />
<? $this->displayPanel('ressource_fullstocks'); ?>