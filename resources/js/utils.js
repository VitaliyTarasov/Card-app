export function gqlErrors(err) {
    const hasInternal = errors => errors.some(e => e.internal);
    const replaceInternal = (errors, err) => hasInternal(errors) ? errors.filter(e => !e.internal).concat(err) : errors;

    if (err?.networkError && err.networkError.statusCode === 419) {
        throw new AuthError("Unauthenticated");
    }
    return replaceInternal((err?.graphQLErrors || []).map(error => {
        
        if ("validation" === error.extensions?.category) {
            const validationError = error.extensions?.validation || {}
            Object.keys(validationError).map(key => validationError[key]);
            
            return Object.keys(validationError).map(key => validationError[key]).flat().map(v => ({
                message: v,
                internal: false
            }));
        }

        return {
            message: error.message,
            internal: Boolean(!(error?.path?.length)),
        }
    }), {
        message: 'Something bad happend'
    }).flat();
}

export class AuthError extends Error {}

export const colorMap400 = {
    teal: "bg-teal-400",
    orange: "bg-orange-400",
    gray: "bg-gray-400",
    yellow: "bg-yellow-400",
    purple: "bg-purple-400",
    red: "bg-red-400",
    green: "bg-green-400",
    blue: "bg-blue-400",
    indigo: "bg-indigo-400",
};