import { z } from 'zod'

export const RegisterValidationSchema = z.object({
    title: z.string().max(255),
    content: z.string(),
    type,
    status,
})