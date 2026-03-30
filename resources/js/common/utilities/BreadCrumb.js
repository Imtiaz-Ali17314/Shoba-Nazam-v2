export function pageRoutes(route) {
    const paths = [];
    paths.push({
        path: route.path,
        name: route.name,
    });
    return paths;
}
export function employeesListRoutes(route) {
    const paths = [];
    paths.push({
        path: route.path,
        name: route.name,
    });
    return paths;
}
export function clientsListRoutes(route) {
    const paths = [];
    paths.push({
        path: route.path,
        name: route.name,
    });
    return paths;
}
export function workSheetRoutes(route, user = null) {
    const paths = [];
    paths.push(
        {
            path: route.path,
            name: route.name,
        },
        {
            path: `/profile/${user.id}`,
            name: user.full_name,
        }
    );
    return paths;
}
export function profileRoutes(route) {
    const paths = [];
    paths.push({
        path: route.path,
        name: route.name,
    });
    return paths;
}
export function userFormRoutes(route) {
    const paths = [];
    paths.push(
        {
            path: `/profile/${route.path.split("/")[3]}`,
            name: "profile",
        },
        {
            path: route.path,
            name: route.name,
        }
    );
    return paths;
}


export function projectDetailRoutes(route) {
        const paths = [];
        paths.push(
            { path: "/projects", name: "projects" },
            {
                path: `/project/${route.params.projectId}/${route.params.slug}`,
                name: 'projectDetail',
            }
        );

        return paths;
}
export function taskDetailRoutes(route) {
        const paths = [];
        paths.push(
            { path: "/projects", name: "projects" },
            {
                path: `/project/${route.params.projectId}/${route.params.slug}`,
                name: 'projectDetail',
            }
        );

        return paths;
}export function productPricesRoutes(route) {
    const paths = [];
    paths.push(
        { path: "/app-admin/products", name: "products" },
        {
            path: route.path,
            name: 'product details',
        }
    );

    return paths;
}

export function companyDetailsRoutes(route) {
    const paths = [];
    paths.push(
        { path: "/app-admin/companies/list", name: "companies" },
        {
            path: route.path,
            name: 'company details',
        }
    );

    return paths;
}

