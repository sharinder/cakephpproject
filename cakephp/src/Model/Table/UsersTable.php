<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->minLength('name',3)
            ->maxLength('name',10)
            ->requirePresence('name', 'create')
            ->notEmptyString('name','Name is Required')
            ->add('name', 'custom', [
                'rule' => array('custom','/^[a-zA-Z_]*$/i'),
                 'message' => 'Please Enter The Proper Name'
            ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email','Email is Required');

        $validator
            ->integer('age')
            ->maxLength('age', 2)
            ->requirePresence('age', 'create')
            ->notEmptyString('age','Age is Required');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 50)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', 'Please Enter The Proper Numbers')
            ->add('phone', 'custom', [
                'rule' => array('custom','/^[0-9_]*$/i'),
                 'message' => 'Please Enter The Proper Numbers'
            ]);

        $validator
            ->scalar('password')
            ->maxLength('password', 50)
            ->requirePresence('password', 'create')
            ->notEmptyString('password','Password is Required')
            ->add('password',
            [
                'Numeric'=> [
                'rule' => ['custom','/[0-9_]/'],
                 'message' => 'Please Enter The Proper Numbers'
                ],
                'uppercase'=> [
                  'rule' => ['custom','/[A-Z_]/'],
                  'message' => 'Please Enter The UpperCase Letters'
                ],
                'lowercase'=> [
                'rule' => ['custom','/[a-z_]/'],
                'message' => 'Please Enter The LowerCase Letters'
                ],
                 'specialcharacter'=> [
                 'rule' => ['custom','/[!@#$%^&*_]/'],
                 'message' => 'Please Enter The SpecialCharacters'
                ],
            ]);
            $validator
            ->allowEmptyFile('image_file')
            ->add( 'image_file', [
            'mimeType' => [
                'rule' => [ 'mimeType', [ 'image/jpg', 'image/png', 'image/jpeg' ] ],
                'message' => 'Please upload only jpg and png.',
            ],
            'fileSize' => [
                'rule' => [ 'fileSize', '<=', '1MB' ],
                'message' => 'Image file size must be less than 1MB.',
            ],
        ] );
        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
