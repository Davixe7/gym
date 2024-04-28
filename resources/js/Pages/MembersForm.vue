<script setup>
import { watch } from 'vue'
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['member'])
const form  = useForm(props.member)

watch(() => props.member, newVal =>{
  form.defaults(newVal)
  form.reset()
})

function save(){
  if( form.picture && form.picture.length ){
    form.picture = form.picture[0]
  }

  if( props.member && props.member.id ){
    updateMember();
    return;
  }
  storeMember();
}

function storeMember(){
  form
  .transform(data=>({...data, _method:'POST'}))
  .post('/members', {
    only: ['createdMember'],
    onSuccess: ()=>{alert('Registrado con éxito')}
  })
}

function updateMember(){
  form
  .transform(data=>({...data, _method:'PUT'}))
  .post(`/members/${props.member.id}`, {
    only: ['updatedMember'],
    onSuccess: () => alert('Actualizado con éxito')
  })
}
</script>

<template>
  <form @submit.prevent="save">
    <div class="row">
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

        <div class="flex justify-end">
          <q-btn
            type="submit"
            :loading="form.processing"
            color="primary"
            class="q-px-lg">
            {{ props.member.id ? 'Actualizar' : 'Guardar' }}
          </q-btn>
        </div>
      </div>
    </div>
  </form>
</template>

<style lang="scss">
.membership-card {
  display: flex;
  > div {
    flex: 1 1 auto;
  }
}
</style>
