Haste Archives Content
==================

- Contributors: allysonsouza, anyssa
- Tags: posts, archives, content, templates
- Requires at least: 3.0.1
- Tested up to: 4.3
- Stable tag: 4.3
- License: GPLv2 or later
- License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates a custom post type Archives for your use to set custom post type archives content.

Description
===========

English (en)
------------

Haste Archives Content creates a custom post type called Archives, and fill then with one post for each custom post type you have registered.
By this way, do you have a post to manage content that can be easily retrieved in your themes archives templates (and in other pages), making your
archives not only a list of posts, but a page with your own content like others.

Português (pt_BR)
-----------------

O Haste Archives Content cria um custom post type chamado Archives, e preenche ele com um post para cada custom post type que você tiver registrado.
Assim você consegue ter um post para gerenciar o conteúdo dos arquivos que podem ser facilmente exibidos nos seus templates archives (e em outras página também),
tornando suas archives não apenas uma listagem de posts, mas uma página gerenciável com o seu próprio conteúdo configurável no painel administrativo.

Installation
============

English (en)
------------
How to install Haste Archives Content:

1. Install trough the WordPress panel or make the download and upload to `/wp-content/plugins/` directory
2. Activate the plugin in 'Plugins' WordPress menu
3. A custom post type called 'Archives' will be created
4. Access the Archives menu and see the posts created for each custom post type do you have registered
5. Edit the posts content
6. Use the plugin API to retrieve data in your archives.php and archives-{post_type}.php

Português (pt_BR)
-----------------
Como instalar o Haste Archives Content:

1. Instale via o painel do WordPress ou faça o upload dos arquivos no diretório `/wp-content/plugins/`
2. Ative o plugin no menu 'Plugins' do WordPress
3. Um custom post type chamado 'Archives' será criado
4. Acesse o menu Archives e veja os posts criados para cada custom post type que você tem registrado
5. Edite o conteúdo dos seus posts como desejar
6. Use a API do plugin para retornar os dados no archives.php e archives-{post_type}.php do seu tema

API
===

haste_archive_content()
-----------------------

This function need to be used within the archive or archive-{post_type} templates.
Returns the object of the post from Archives custom post type related to the current
archive that has being displayed.

get_haste_archive_content( [string post_type] )
-----------------------
Returns the object of the post from Archives custom post type from the given post type
passed as parameter to the function.

Examples
--------

**Displaying Content and Custom Field**

```	
<?php
	$archive_post = haste_archive_content(); 
	
	echo $archive_post->post_content;
		
	$subtitle = get_post_meta( $archive_post->ID, 'subtitle', true );
		
	if( ! empty( $subtitle ) ) {
			echo $subtitle;
	}
?>
```
	
**Displaying Title from a given post type**
```
<?php
	$archive_post = get_haste_archive_content( 'video' ); 
	
	echo $archive_post->post_title;
?>
```

FAQ
===

Português (pt_BR)
----------------

**Os built-in post types não tem posts criados?**

Nessa versão ainda não, na verdade, isso precisa ser pensado, um maior controle sobre a criação, recriação e exclusão dos posts precisaria ser adicionada.

Screenshots
===========

![alt tag](/assets/screenshot-1.png?raw=true " Haste Archives Content (Listagem de posts baseados nos custom post types)")
