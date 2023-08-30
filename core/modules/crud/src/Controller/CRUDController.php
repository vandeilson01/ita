<?php

/**
 * @file
 * @Contains Drupal\crud\Controller\CRUDController.
 */

namespace Drupal\crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\file\Entity\File;

/**
 * Implement CRUD class operations.
 */
class CRUDController extends ControllerBase {
    public function index() {
        //create table header
        $header_table = [
            'id' => $this->t('ID'),
            'name' => $this->t('Nome'),
            'cpf' => $this->t('CPF'),
            'view' => $this->t('Ver'),
            'delete' => $this->t('Deletar'),
            'edit' => $this->t('Editar'),
        ];

        // get data from database
        $query = \Drupal::database()->select('crud_table', 'm');
        $query->fields('m', [
            'id',
            'name',
            'cpf',
        ]);
        $results = $query->execute()->fetchAll();
        $rows = [];
        foreach ($results as $data) {
            $url_delete = Url::fromRoute('crud.delete_form', ['id' => $data->id], []);
            $url_edit = Url::fromRoute('crud.add_form', ['id' => $data->id], []);
            $url_view = Url::fromRoute('crud.show_data', ['id' => $data->id], []);
            $linkDelete = Link::fromTextAndUrl('  Deletar  ', $url_delete);
            $linkEdit = Link::fromTextAndUrl('  Editar  ', $url_edit);
            $linkView = Link::fromTextAndUrl('  Ver  ', $url_view);

            //get data
            $rows[] = [

                'id' => $data->id,
                'name' => $data->name,
                'cpf' => $data->cpf,
                // 'id' => $data->id,
                // 'first_name' => $data->first_name,
                // 'last_name' => $data->last_name,
                // 'email' => $data->email,
                // 'message' => $data->message,
                // // 'phone' => $data->phone,
                'view' => $linkView,
                'delete' => $linkDelete,
                'edit' =>  $linkEdit,
            ];
        }
        // render table
        $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => $this->t('Nenhum dado encontrado'),
            '#wrapper_attributes' => [
                'class' =>[
                  'table',
                ],
            ],
        ];
        return $form;
    }

    public function show(int $id) {
        $conn = Database::getConnection();

        $query = $conn->select('crud_table', 'm')
            ->condition('id', $id)
            ->fields('m');
        $data = $query->execute()->fetchAssoc();
        $name = $data['name'];
        $cpf = $data['cpf'];

        $ano_entrada = $data['ano_entrada'];
        $ano_formatura = $data['ano_formatura'];
        $especialidade = $data['especialidade'];
        $especialidade_qual = $data['especialidade_qual'];
        $civil_militar = $data['civil_militar'];
        $apelido = $data['apelido'];
        $numero_matricula = $data['numero_matricula'];
        $ano_nascimento = $data['ano_nascimento'];
        $cpf = $data['cpf'];
        $sexo = $data['sexo'];
        $posto_formatura = $data['posto_formatura'];
        $nome_mae = $data['nome_mae']; 
        $telefone_celular = $data['telefone_celular'];
        // $phone = $data['phone'];
        // $message = $data['message'];

        $file = File::load($data['fid']);
        // $picture = $file->createFileUrl();

        return [
            '#type' => 'markup',
            '#markup' => "<h1>$name</h1><br>
            <p><strong>Sexo:</strong> $sexo</p>
            <p><strong>Ano entrada:</strong> $ano_entrada</p>
            <p><strong>Ano formatura:</strong> $ano_formatura</p>
            <p><strong>Especialidade:</strong> $especialidade</p>
            <p><strong>Especialidade(Outra):</strong> $especialidade_qual</p>
            <p><strong>Civil/Militar:</strong> $civil_militar</p>
            <p><strong>Apelido:</strong> $apelido</p>
            <p><strong>Número Matricula:</strong> $numero_matricula</p>
            <p><strong>Ano Nascimento:</strong> $ano_nascimento</p>
            <p><strong>CPF:</strong> $cpf</p>
            <p><strong>Posto Formatura:</strong> $posto_formatura</p>
            <p><strong>Nome Mãe:</strong> $nome_mae</p> 
            <p><strong>Telefone/Celular:</strong> $telefone_celular</p>
            "
        ];
    }
}
