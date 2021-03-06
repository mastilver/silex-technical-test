<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/*     SETUP     */

$app->get('/setup', function() use ($app)
{ 
	$sql = "CREATE TABLE IF NOT EXISTS news (
		id	INT NOT NULL,
		title TEXT,
		short_desc TEXT,
		body TEXT,
		PRIMARY KEY(id)
	)";
	$post = $app['db']->query($sql);
	for($i=1; $i<11; $i++) {
		$sql = "INSERT INTO news (id, title, short_desc, body) VALUES
			($i, 'Test $i', 'Test $i', 'Test $i')";
		$post = $app['db']->query($sql);
	}
	
	return "done";
});



/*     WEBSITE     */

$app->get('/{page}', function($page) use($app)
{
	return $app['twig']->render('home.twig', array(	'news' => $app['news']->get_page($page),
													'total_page' => $app['news']->get_nbr_page(),
													'current_page' => $page));
})
->value('page', 1);

$app->get('/news/{id}', function($id) use ($app)
{	
	return $app['twig']->render('new.twig', array('new' => $app['news']->get_id($id)));
});


$app->post('/addnews', function(Request $request) use($app)
{
	$app['news']->add_news(array(
								'title' => $request->get('title'),
								'short_desc' => $request->get('short_desc'),
								'body' => $request->get('news_content')));	
	
	return $app->redirect('./');
});

