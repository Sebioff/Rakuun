<? if ($this->hasErrors()): ?>
	<? $this->displayErrors(); ?>
<? endif; ?>
<? if ($this->params->type == Rakuun_Intern_GUI_Panel_User_Directory::TYPE_MESSAGES): ?>
	<ul>
		<li>
			<u>System</u>
			<dl>
				<dt>Support</dt>
				<dd>
					<? // TODO replace with correct action/url as soon as support has been implemented
					$link = new GUI_Control_Link(
						'support',
						'write',
						App::get()->getInternModule()->getSubmodule('messages')->getURL(array('category' => Rakuun_Intern_GUI_Panel_Message_Categories::CATEGORY_SUPPORTTICKETS))
					); ?>
					<? $link->display(); ?>
				</dd>
			</dl>
		</li>
	</ul>
	<? if (!empty($this->params->groups)): ?>
		<ul>
			<? foreach ($this->params->groups as $group): ?>
				<li>
					<u><?= $group['group']->name; ?></u>
					<? if (!empty($group['entities'])): ?>
						<dl>
							<? foreach ($group['entities'] as $entity): ?>
								<dt>
									<? $userLink = new Rakuun_GUI_Control_UserLink('userlink'.$entity->getPK(), $entity->user); ?>
									<? $userLink->display(); ?>
								</dt>
								<dd>
									<? $link = new GUI_Control_JsLink(
										'link'.$entity->getPK(),
										'write',
										// FIXME Evil hardcoded stuff, don't hit me too hard
										'$(\'#main-messages_content-send-send-recipients\').val($(\'#main-messages_content-send-send-recipients\').val() + \''.$entity->user->nameUncolored.', \');return false;'
										// Link needs fallback-url
									); ?>
									<? $link->display(); ?>
								</dd>
							<? endforeach; ?>
						</dl>
					<? endif; ?>
				</li>
		<? endforeach; ?>
		</ul>
	<? endif; ?>
<? elseif ($this->params->type == Rakuun_Intern_GUI_Panel_User_Directory::TYPE_ARMY): ?>
	<? //TODO: Need to be implemented ?>
<? endif; ?>
<hr />
<? $link = new GUI_Control_Link('editlink', 'bearbeiten', Router::get()->getCurrentModule()->getURL(array('edit' => true))); ?>
<? $link->display(); ?>
<br />
<? $this->displayLabelForPanel('name'); ?>
<? $this->displayPanel('name'); ?>
<br class="clear" />
<? $this->displayPanel('submit'); ?>