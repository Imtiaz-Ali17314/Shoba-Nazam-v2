// src/validationSchema.js

import * as yup from "yup";

// Define the schema outside of the component
export const formSchema = yup.object().shape({
    // name: yup
    //     .string()
    //     .required("Name is required")
    //     .min(2, "Name must be at least 2 characters")
    //     .matches(/^[A-Za-z\s]+$/, "Name must only contain letters and spaces"),

    email: yup
        .string()
        .email("Invalid email address")
        .required("Email is required")
        .min(5, "Email must be at least 5 characters"),

    // phone: yup
    //     .string()
    //     .required("Phone number is required"),

    // age: yup
    //     .number()
    //     .required("Age is required")
    //     .positive("Age must be a positive number")
    //     .integer("Age must be an integer")
    //     .min(18, "You must be at least 18 years old")
    //     .max(100, "Age cannot exceed 100 years"),

    password: yup
        .string()
        .min(8, "Password must be at least 8 characters")
        // .matches(/[a-zA-Z]/, "Password must contain at least one letter")
        // .matches(/\d/, "Password must contain at least one number")
        // .matches(/[@$!%*?&]/, "Password must contain at least one special character")
        .required("Password is required"),

    password_confirmation: yup
        .string()
        .oneOf([yup.ref("password"), null], "Passwords must match")
        .required("Confirm password is required"),
});
