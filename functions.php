<?php
global $Wcms;
function getPageBlocks(string $key, string $page): string
{
	global $Wcms;
	$segments = $Wcms->get('pages', $page);
	$segments->content = $segments->content ?? '<h2>Click here add content</h2>';
	$keys = [
		'title' => $segments->title,
		'description' => $segments->description,
		'keywords' => $segments->keywords,
		'content' => $Wcms->loggedIn && $page == $Wcms->currentPage
			? $Wcms->editable('content', $segments->content, 'pages')
			: $segments->content
	];
	$content = $keys[$key] ?? '';
	return getPageHook('page', $content, $key)[0];
}
function getPageHook(): array
{
	global $Wcms;
	$numArgs = func_num_args();
	$args = func_get_args();
	if ($numArgs < 2) {
		trigger_error('Insufficient arguments', E_USER_ERROR);
	}
	$hookName = array_shift($args);
	if (!isset($Wcms->listeners[$hookName])) {
		return $args;
	}
	foreach ($Wcms->listeners[$hookName] as $func) {
		$args = $func($args);
	}
	return $args;
}

?>
