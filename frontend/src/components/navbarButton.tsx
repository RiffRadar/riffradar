'use client'

import Image from 'next/image'
import Link from 'next/link'
import { usePathname } from 'next/navigation'

export default function NavbarButton({
    href,
    name,
    image,
}: {
    href: string
    name: string
    image: string
}) {
    const pathname: string = usePathname()

    return (
        <Link
            href={href}
            className={`flex items-center text-xl font-bold rounded px-2 gap-2 text-white hover:bg-bg_secondary ${
                pathname === href ? '' : ''
            }`}
        >
            <Image src={image} alt={''} width={28} height={28} />
            {name}
        </Link>
    )
}
