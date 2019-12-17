<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      Trander
    </RouterLink>
    <div class="navbar__menu">
      <span class="navbar__item">
        username
      </span>
      <div class="navbar__item">
        <RouterLink class="button button--link" to="/login">
          Login / Register
        </RouterLink>
      </div>
    </div>
  </nav>
</template>