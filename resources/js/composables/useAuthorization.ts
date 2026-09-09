import { usePage } from '@inertiajs/vue3';

export function useAuthorization() {
    const page = usePage();

    function can(permissions: string | string[]): boolean {
        if (page.props.is_super_admin) {
            return true;
        }

        const requiredPermissions = Array.isArray(permissions) ? permissions : [permissions];

        return requiredPermissions.every((permission) => page.props.permissions.includes(permission));
    }

    return { can };
}
