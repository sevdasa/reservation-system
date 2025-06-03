import { createInertiaApp } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { renderToString } from '@vue/server-renderer';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createSSRApp, DefineComponent, h } from 'vue';
import { route as ziggyRoute } from 'ziggy-js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createServer((page) =>
  createInertiaApp({
    page,
    render: renderToString,
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
      resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
      ),
    setup({ App, props, plugin }) {
      const ziggyProps = page.props.ziggy && typeof page.props.ziggy === 'object' ? page.props.ziggy : {};

      const ziggyConfig = {
        ...ziggyProps,
        location:
          typeof window !== 'undefined' && (ziggyProps as any).location
            ? new URL((ziggyProps as any).location)
            : new URL('http://localhost'),
      };

      const app = createSSRApp({ render: () => h(App, props) });
      app.use(plugin);

      app.config.globalProperties.route = (...args: any[]) =>
        (ziggyRoute as (...args: any[]) => any)(...args, ziggyConfig).toString();

      if (typeof window === 'undefined') {
        (globalThis as any).route = app.config.globalProperties.route;
      }

      return app;
    },
  }),
);
