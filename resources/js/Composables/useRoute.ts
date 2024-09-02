// @ts-ignore
import { Ziggy } from '@/routes.js'
// @ts-ignore
import { useRoute as useZiggyRoute } from 'ziggy-js'
import type { RouteName } from '@/Types/Routes'

export function useRoute (name: RouteName, params: Object = {}, absolute: boolean = true) {
    const route = useZiggyRoute(Ziggy)

    return route(name, params, absolute)
}
