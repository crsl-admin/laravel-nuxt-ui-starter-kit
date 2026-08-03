import { route as ziggyRoute } from 'ziggy-js';

// ponytail: Ziggy's `absolute` param defaults to true and overwrites config.absolute
// on every call, so a global config default is impossible. Wrap once to make routes
// relative by default → URLs stay internal so Inertia (and NuxtUI links) intercept them.
// Pass `true` as the 3rd arg when you explicitly need an absolute URL.
export const route = ((name?: any, params?: any, absolute = false, config?: any) =>
    ziggyRoute(name, params, absolute, config)) as typeof ziggyRoute;
