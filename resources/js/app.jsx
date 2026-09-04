import React from 'react'
import ReactDOM from 'react-dom'
import { createInertiaApp } from '@inertiajs/react'
import { ZiggyRoutes } from 'laravel-vite-plugin/vue3'
import { Ziggy } from './ Ziggy'

createInertiaApp({
  title: (title) => `${title} | PNB Travel`,
  resolve: (name) => `../Pages/${name}`,
  setup: ({ el, App, props }) => {
    return React.createElement(App, props)
  },
  progress: {
    // Check page progress bar color
    color: '#3B82F6',
  },
})

ReactDOM.createRoot(el).render(
  <React.StrictMode>
    <App {...Ziggy.initialProps} />
  </React.StrictMode>
)
