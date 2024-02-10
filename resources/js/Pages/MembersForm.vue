<script setup>
import { watch } from 'vue'
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['member'])
const defaultMember = {id: null, name: '', age: '', dni: '', phone: '', picture: null}
const form = useForm(props.member?.id ? {...props.member} : {...defaultMember})

watch(() => props.member, newVal =>{
  console.log( 'newVal', newVal )
  form.defaults(newVal?.id ? newVal : {...defaultMember})
  form.reset()
})

function save(){
  form.picture = form.picture[0]
  if( props.member?.id ){
    updateMember();
    return;
  }
  storeMember();
}

function storeMember(){
  form
  .transform(data=>({...data, _method:'POST'}))
  .post('/members', {
    onSuccess: ()=>{alert('Registrado con éxito')}
  })
}

function updateMember(){
  form
  .transform(data=>({...data, _method:'PUT'}))
  .post(`/members/${props.member.id}`, {
    onSuccess: ()=>{alert('Actualizado con éxito')}
  })
}
</script>

<template>
  <q-card style="width: 560px; margin: 0 auto;">
    <q-card-section>
      <form @submit.prevent="save">
        <div class="row">
          <!-- <div class="col-md-6 q-pr-md">
            <div class="d-flex justify-center items-center"
              style="background: rgba(0,0,0,.25); border-radius: 3px; padding: 1rem; height: 270px;">
            </div>
          </div> -->
          <div class="col-md-12 q-gutter-y-md">
            <div class="flex">
              <q-avatar rounded size="60px" class="q-mr-md" color="grey">
                <q-img v-if="member.picture" :src="member.picture"></q-img>
              </q-avatar>
              <q-input outlined stack-label hide-bottom-space :error="Boolean(form.errors.picture)"
                :error-message="form.errors.picture ? form.errors.picture : ''" label="Foto de perfil"
                v-model="form.picture" type="file" style="flex: 1 1 auto;"/>
            </div>

            <q-input outlined stack-label hide-bottom-space :error="Boolean(form.errors.name)"
              :error-message="form.errors.name ? form.errors.name : ''" label="Nombre" v-model="form.name" />

            <q-input outlined stack-label hide-bottom-space :error="Boolean(form.errors.age)"
              :error-message="form.errors.age ? form.errors.age : ''" label="Edad" v-model.number="form.age"
              type="number" />

            <q-input outlined stack-label hide-bottom-space :error="Boolean(form.errors.dni)"
              :error-message="form.errors.dni ? form.errors.dni : ''" label="Cédula" v-model="form.dni" />

            <q-input outlined stack-label hide-bottom-space :error="Boolean(form.errors.phone)"
              :error-message="form.errors.phone ? form.errors.phone : ''" label="Teléfono" v-model="form.phone"
              type="tel" />
          </div>
        </div>
      </form>
    </q-card-section>
    <q-card-actions class="flex">
      <q-btn type="submit" @click="save" :loading="form.processing" color="primary" class="q-ml-auto q-px-xl">
        {{
          form.id
          ? 'Actualizar'
          : 'Guardar'
        }}
      </q-btn>
    </q-card-actions>
  </q-card>
</template>
