<?php


function ita_preprocess_block(&$variables) {
  $block_counter = &drupal_static(__FUNCTION__, array());
  $variables['block'] = $variables['elements']['#block'];
  // All blocks get an independent counter for each region.
  if (!isset($block_counter[$variables['block']->region])) {
    $block_counter[$variables['block']->region] = 1;
  }
  // Same with zebra striping.
  $variables['block_zebra'] = ($block_counter[$variables['block']->region] % 2) ? 'odd' : 'even';
  $variables['block_id'] = $block_counter[$variables['block']->region]++;

  // Create the $content variable that templates expect.
  $variables['content'] = $variables['elements']['#children'];

  $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->region;
  $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->module;
  // Hyphens (-) and underscores (_) play a special role in theme suggestions.
  // Theme suggestions should only contain underscores, because within
  // drupal_find_theme_templates(), underscores are converted to hyphens to
  // match template file names, and then converted back to underscores to match
  // pre-processing and other function names. So if your theme suggestion
  // contains a hyphen, it will end up as an underscore after this conversion,
  // and your function names won't be recognized. So, we need to convert
  // hyphens to underscores in block deltas for the theme suggestions.
  $variables['theme_hook_suggestions'][] = 'block__' . $variables['block']->module . '__' . strtr($variables['block']->delta, '-', '_');

  // Create a valid HTML ID and make sure it is unique.
  $variables['block_html_id'] = drupal_html_id('block-' . $variables['block']->module . '-' . $variables['block']->delta);
}

?>


<?php
function ita_preprocess_views_view_unformatted(&$vars) {
  $view = $vars['view'];
  $rows = $vars['rows'];
  $style = $view->style_plugin;
  $options = $style->options;

  $vars['classes_array'] = array();
  $vars['classes'] = array();
  $default_row_class = isset($options['default_row_class']) ? $options['default_row_class'] : FALSE;
  $row_class_special = isset($options['row_class_special']) ? $options['row_class_special'] : FALSE;
  // Set up striping values.
  $count = 0;
  $max = count($rows);
  
 foreach ($rows as $id => $row) {
    $count++;
    $vars['classes'][$id][] = 'item';
    $vars['classes'][$id][] = 'item-' . $count;
    if ($count == 1) {
      $vars['classes'][$id][] = 'first';
    }
    if ($count == $max) {
      $vars['classes'][$id][] = 'last';
    }

    if ($row_class = $view->style_plugin->get_row_class($id)) {
      $vars['classes'][$id][] = $row_class;
    }

    // Flatten the classes to a string for each row for the template file.
    $vars['classes_array'][$id] = isset($vars['classes'][$id]) ? implode(' ', $vars['classes'][$id]) : '';
  }
}

?>

<?php
function ita_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    $form['search_block_form']['#title'] = t('Buscar'); // Change the text on the label element
    $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
    $form['search_block_form']['#default_value'] = t('Digite aqui para pesquisar'); // Set a default value for the textfield
    $form['actions']['submit']['#value'] = t(''); // Change the text on the submit button
    $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Digite aqui para pesquisar';}";
    $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Digite aqui para pesquisar') {this.value = '';}";
    $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Digite aqui para pesquisar'){ alert('Por favor digite algo para buscar!'); return false; }";
  }
}
?>

<?php
//Sobrescrevendo theme_pager
/**
* Implements hook_html_head_alter().
*/
function ita_html_head_alter(&$head_elements) {
  // Remove Drupal generator meta tag.
  // Use this if you want to remove the Drupal 7 Generator meta tag.
  //if (isset($head_elements['system_meta_generator'])) {
    unset($head_elements['system_meta_generator']);
    foreach ($head_elements as $key => $element) {
        if (isset($element['#attributes']['rel']) && $element['#attributes']['rel'] == 'canonical') {
          unset($head_elements[$key]);
        }
        if (isset($element['#attributes']['rel']) && $element['#attributes']['rel'] == 'shortlink') {
          unset($head_elements[$key]);
        }
    }
  //}
}

function ita_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('Ir para primeira pagina')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('Pagina Anterior')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('Proxima pagina')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('Ir para ultima pagina')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
	  
    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
   
    
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
	
	
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    
   
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
   
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pager')),
    ));
  }
}

?>
