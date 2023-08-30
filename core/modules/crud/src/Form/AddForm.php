<?php

/**
 * @file
 * @Contains Drupal\crud\Form\AddForm.
 */

namespace Drupal\crud\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\file\Entity\File;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Add form implementation.
 */
class AddForm extends FormBase {
    /**
     * (@inheritdoc)
     */
    public function getFormId() {
        return 'crud_form_id';
    }

    /**
     * (@inheritdoc)
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $conn = Database::getConnection();
        $data = [];
        if (isset($_GET['id'])) {
            $query = $conn->select('crud_table', 'm')
                ->condition('id', $_GET['id'])
                ->fields('m');
            $data = $query->execute()->fetchAssoc();
        }

        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Nome'),
            '#default_value' => (isset($data['name'])) ? $data['name'] : '',
            '#required' => TRUE,
            '#wrapper_attributes' => ['class' => 'col-md-6 col-12'],
        ];
        $form['sexo'] = [
            '#type' => 'select',
            '#title' => $this
                ->t('Sexo'),
            '#options' => [
                'M' => $this
                    ->t('Masculino'),
                'F' => $this
                    ->t('Feminino'),
            ],
            '#default_value' => (isset($data['sexo'])) ? $data['sexo'] : '',
            '#wrapper_attributes' => ['class' => ' col-md-6 col-xs-12'],
        ];
        $form['ano_entrada'] = [
            '#type' => 'date',
            '#title' => $this->t('Ano de entrada'),
            '#default_value' => (isset($data['ano_entrada'])) ? $data['ano_entrada'] : '',
            '#required' => TRUE,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];
        $form['ano_formatura'] = [
            '#type' => 'date',
            '#title' => $this->t('Ano de formatura'),
            '#default_value' => (isset($data['ano_formatura'])) ? $data['ano_formatura'] : '',
            '#required' => false,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];
        $form['especialidade'] = [
            '#type' => 'select',
            '#title' => $this
                ->t('Especialidade'),
            '#options' => [
                '1' => $this->t('Aeroespacial'),
                '2' => $this->t('Aeronáutica'),
                '3' => $this->t('Aeronaves'),
                '4' => $this->t('Aerovias'),
                '5' => $this->t('Civil-Aeronáutica'),
                '6' => $this->t('Computação'),
                '7' => $this->t('Eletrônica'),
                '8' => $this->t('Infra-Estrutura Aeronáutica'),
                '9' => $this->t('Mecânica'),
                '10' => $this->t('Mecânica-Aeronáutica'),
                '11' => $this->t('Outra (qual? - texto simples)'),
            ],
            '#default_value' => (isset($data['especialidade'])) ? $data['especialidade'] : '',
            '#wrapper_attributes' => ['class' => ' col-md-6 col-xs-12'],
        ];

    
        $form['especialidade_qual'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Outra? Qual?'),
            '#default_value' => (isset($data['especialidade_qual'])) ? $data['especialidade_qual'] : '',
            '#required' => false,
            '#wrapper_attributes' => ['class' => 'col-md-6 col-12'],
        ];
     
        $form['civil_militar'] = [
            '#type' => 'select',
            '#title' => $this
                ->t('Sexo'),
            '#options' => [
                'Civil' => $this
                    ->t('Civil'),
                'Militar' => $this
                    ->t('Militar'),
            ],
            '#default_value' => (isset($data['civil_militar'])) ? $data['civil_militar'] : '',
            '#wrapper_attributes' => ['class' => ' col-md-6 col-xs-12'],
        ];

        
        $form['posto_formatura'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Posto na formatura'),
            '#default_value' => (isset($data['posto_formatura'])) ? $data['posto_formatura'] : '',
            '#required' => false,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];
        

        $form['apelido'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Apelido'),
            '#default_value' => (isset($data['apelido'])) ? $data['apelido'] : '',
            '#required' => TRUE,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];

        $form['numero_matricula'] = [
            '#type' => 'number',
            '#title' => $this->t('Número de matrícula'),
            '#default_value' => (isset($data['numero_matricula'])) ? $data['numero_matricula'] : '',
            '#required' => false,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];

        $form['ano_nascimento'] = [
            '#type' => 'date',
            '#title' => $this->t('Ano de nascimento'),
            '#default_value' => (isset($data['ano_nascimento'])) ? $data['ano_nascimento'] : '',
            '#required' => TRUE,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];

        $form['cpf'] = [
            '#type' => 'textfield',
            '#title' => $this->t('CPF'),
            '#default_value' => (isset($data['cpf'])) ? $data['cpf'] : '',
            '#required' => TRUE,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];
 
        $form['nome_mae'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Nome da mãe'),
            '#default_value' => (isset($data['nome_mae'])) ? $data['nome_mae'] : '',
            '#required' => TRUE,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];

        $form['telefone_celular'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Telefone celular'),
            '#default_value' => (isset($data['telefone_celular'])) ? $data['telefone_celular'] : '',
            '#required' => false,
            '#wrapper_attributes' => ['class' => ' col-md-6 col-12'],
        ];

        // $form['picture'] = [
        //     '#type' => 'managed_file',
        //     '#title' => $this->t('Foto'),
        //     '#description' => $this->t('Choosier Image gif png jpg jpeg'),
        //     '#required' => (isset($_GET['id'])) ? FALSE : TRUE,
        //     '#upload_location' => 'public://images/',
        //     '#upload_validators' => [
        //         'file_validate_extension' => ['png jpeg jpg'],
        //     ]
        // ];
        // $form['phone'] = [
        //     '#type' => 'tel',
        //     '#title' => $this->t('phone'),
        //     '#required' => true,
        //     '#default_value' => ' ',
        //     '#wrapper_attributes' => ['class' => 'col-md-6 col-xs-12']
        // ];
        // $form['select'] = [
        //     '#type' => 'select',
        //     '#title' => $this
        //         ->t('Select element'),
        //     '#options' => [
        //         '1' => $this
        //             ->t('One'),
        //         '3' => $this
        //             ->t('Three'),
        //     ],
        //     '#default_value' => (isset($data['select'])) ? $data['select'] : '',
        //     '#wrapper_attributes' => ['class' => 'col-md-6 col-xs-12'],
        // ];
        // $form['message'] = [
        //     '#type' => 'textarea',
        //     '#title' => $this->t('message'),
        //     '#required' => true,
        //     '#default_value' => (isset($data['message'])) ? $data['message'] : '',
        //     '#wrapper_attributes' => ['class' => 'col-md-6 col-xs-12'],
        // ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Salvar'),
            '#buttom_type' => 'primary',
        ];

        return $form;
    }

    /**
     * (@inheritdoc)
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if (is_numeric($form_state->getValue('name'))) {
            $form_state->setErrorByName('name', $this->t('Error, The First Name Must Be A String'));
        }
        
 
    }

    /**
     * (@inheritdoc)
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // $picture = $form_state->getValue('picture');
        $data = [
            // 'first_name'    => $form_state->getValue('first_name'),
            // 'last_name'     => $form_state->getValue('last_name'),
            // 'email'         => $form_state->getValue('email'),
            // // 'phone'         => $form_state->getValue('phone'),
            // // 'select'        => $form_state->getValue('select'),
            // 'message'       => $form_state->getValue('message'),
            'name' => $form_state->getValue('name'),
            'sexo' => $form_state->getValue('sexo'),
            'ano_entrada' => $form_state->getValue('ano_entrada'),
            'ano_formatura' => $form_state->getValue('ano_formatura'),
            'especialidade' => $form_state->getValue('especialidade'),
            'civil_militar' => $form_state->getValue('civil_militar'),
            'apelido' => $form_state->getValue('apelido'),
            'numero_matricula' => $form_state->getValue('numero_matricula'),
            'ano_nascimento' => $form_state->getValue('ano_nascimento'),
            'cpf' => $form_state->getValue('cpf'),
            'nome_mae' => $form_state->getValue('nome_mae'),
            'telefone_celular' => $form_state->getValue('telefone_celular'),
            'posto_formatura' => $form_state->getValue('posto_formatura'),
            'especialidade_qual' => $form_state->getValue('especialidade_qual'),
        ];

        // if (!is_null($picture[0])) {
        //     $data += [
        //         'fid' => $picture[0],
        //     ];
        // }

        if (isset($_GET['id'])) {
            // update data in database
            \Drupal::database()->update('crud_table')->fields($data)->condition('id', $_GET['id'])->execute();
        } else {
            // Insert data to database.
            \Drupal::database()->insert('crud_table')->fields($data)->execute();
        }
        // if (!is_null($picture[0])) {
        //     // Save file as Permanent.
        //     $file = File::load($picture[0]);
        //     $file->setPermanent();
        //     $file->save();
        // }

        // Show message and redirect to list page.
        \Drupal::messenger()->addStatus($this->t('Successfully saved'));
        $url = new Url('crud.display_data');
        $response = new RedirectResponse($url->toString());
        $response->send();
    }
}
