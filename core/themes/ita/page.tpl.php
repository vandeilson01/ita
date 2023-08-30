<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
</head>
<body>
    <div id="cabecalho">
      <div class="cabecalho_wrapper">
        <a href="<?php print $front_page ?>" class="logomarca">Instituto Tecnológico de Aeronáutica - Homepage</a>
        <div class="logotipo">Instituto Tecnológico de Aeronáutica</div>
        <?php if ($page['header']): ?>
          <?php print render($page['header']); ?>
        <?php endif; ?>
      </div>
    </div>

	<div id="menu">
		<?php if ($page['menu']): ?>
				<?php print render($page['menu']); ?>
		<?php endif; ?>
	</div>
	<div id="titulopag">
		<?php if ($title): ?>
			<h1><?php print $title ?></h1>
		<?php endif; ?>
    <?php print $breadcrumb; ?>
		<div id="clear"></div>
	</div>
	<?php if ($page['notice']): ?>
		<div id="noticias">
			<?php print render($page['notice']); ?>
			<div id="clear"></div>
		</div>
	<?php endif; ?>
	<div id="<?php if ($page['sec_menu']){echo "conteudo_bgmenu";} else{echo "conteudo_bg";} ?>">
		<div id="wrapper_conteudo">
			<?php if ($page['sec_menu']): ?>
				<div id="secmenu">
					<?php print render($page['sec_menu']); ?>
				</div>
			<?php endif; ?>
			<?php if ($page['aux_content']): ?>
				<div id="conteudo_auxiliar">
					<?php print render($page['aux_content']); ?>
				</div>
			<?php endif; ?>
			<div id="conteudo_principal">
				<div id="pagina">
					<?php if ($tabs): ?>
						<div class="tabs">
						  <?php print render($tabs); ?>
						</div>
					<?php endif; ?>
					<?php print $messages; ?>
					<?php print render($page['main_content']); ?>
				</div>
				<div id="news_divisoes">
					<?php print render($page['news_divisoes']); ?>
				</div>
			</div>
			<div id="clear"></div>
		</div>
	</div>

	<div id="footer">
		<div class="background_info">
			<div class="info_wrapper">
				<div class="logo">
				Instituto Tecnológico de Aeronáutica
				</div>
				<div class="endereco">
          <a href="../localizacao" title="Localizacao">
            <span> Praça Marechal Eduardo Gomes, 50 </span>
            <span>Vila das Acácias, 12228-900</span>
            <span>São José dos Campos/SP - Brasil</span>
          </a>
				</div>
				<div class="apoios">
					<div class="dcta">
						<a href="http://www.cta.br" target="_blank">Departamento de Ciência e Tecnologia Aeroespacial</a>
					</div>
				</div>
			</div>
		</div>
    <div class="wrapper">
      <div class="menu_wrapper">
      <?php if ($page['footer']): ?>
        <div class="menu">
          <?php print render($page['footer']); ?>
        </div>
      <?php endif; ?>

      <?php if ($page['social']): ?>
        <div class ="social">
        <?php print render($page['social']); ?>
        </div>
      <?php endif; ?>
      </div>
    </div>
	</div>

</body>
</html>
