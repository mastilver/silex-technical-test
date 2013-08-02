<div style="text-align: right"></div><?php

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

$app->get('/', function () use($app)
{
	return $app['twig']->render('home.twig', array('news' => $app['news']->get_latest()));
});

$app->get('/{id}', function ($id) use ($app)
{
	return $app['twig']->render('new.twig', array('new' => $app['news']->get_id($id)));
});
