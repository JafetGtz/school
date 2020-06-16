const mixin = {
  bind(el, binding) {
    // Provided expression must evaluate to a function.
    if (typeof binding.value !== 'function') return

    // Define Handler and cache it on the element
    const { bubble } = binding.modifiers
    const handler = e => {
      if (bubble || (!el.contains(e.target) && el !== e.target)) {
        binding.value(e)
      }
    }
    el.__clickAway__ = handler
    // add Event Listeners
    document.addEventListener('click', handler)
  },

  unbind(el) {
    if (!el.__clickAway__) return
    // Remove Event Listeners
    document.removeEventListener('click', el.__clickAway__)
    delete el.__clickAway__
  },
}

export default mixin
