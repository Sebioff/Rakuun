Ziel: <?= $this->userLink->render(); ?>
<br/>
<?= date(GUI_Panel_Date::FORMAT_DATETIME, $this->report->time); ?>
<br/>
<?= $this->reportTable->render(); ?>