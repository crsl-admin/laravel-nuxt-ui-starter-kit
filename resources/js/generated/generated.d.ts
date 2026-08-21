declare namespace App {
    namespace Data {
        export type PasskeyData = {
            id: number;
            name: string;
            authenticator: string | null;
            last_used_at: string | null;
            created_at: string | null;
        };
        export type UserData = {
            full_name: string;
            first_name: string;
            last_name: string;
            email: string;
            avatar_url: string | null;
        };
    }
}
