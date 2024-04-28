<template>
  <q-layout view="hHh lpR fFf">

    <q-header bordered class="bg-primary text-white">
      <q-toolbar>
        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
          </q-avatar>
          Admin
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-page-container style="background: #f6f9fc;">
      <q-page>
        <slot></slot>
      </q-page>
    </q-page-container>

  </q-layout>
</template>

<script setup></script>

<style lang="scss">
.q-toolbar {
  min-height: 56px !important;
}
</style>
