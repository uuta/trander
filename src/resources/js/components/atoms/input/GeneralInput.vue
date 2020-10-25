<template>
  <input
    class="c-input_general"
    :type="type"
    :name="name"
    :value="value"
    :placeholder="placeholder"
    @input="updateValue"
  />
</template>

<script>
export default {
  name: "GeneralInput",
  props: {
    value: { type: String, required: true },
    type: { type: String, required: true },
    name: { type: String, required: true },
    placeholder: { type: String, required: false }
  },
  methods: {
    updateValue(e) {
      this.$emit("input", e.target.value);
    }
  }
};
</script>
