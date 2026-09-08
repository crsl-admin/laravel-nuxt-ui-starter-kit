export type Auth = {
    user: App.Data.UserData | null;
    can: {
        viewCustomers: boolean;
    };
};
